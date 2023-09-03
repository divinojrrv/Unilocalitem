<?php

namespace App\Http\Controllers;


use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use App\Models\Bloco;
use App\Models\Categoria;
use App\Models\Publicacoes;
use App\Models\Resgate;
use App\Models\ImagensObjetos;
use App\Models\Imagens;
use App\Repositories\PublicacoesRepository;
use App\Repositories\UsuarioRepository;
use Illuminate\Http\Request;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Hash;
use App\Http\Requests\RegisterUsuariosRequest;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Validator;


class ResgatesController extends Controller
{
   /**
     *
     * @var PublicacoesRepository
     * @var UsuarioRepository
     */
    private $publicacoesRepository;
    private $usuariosRepository;
    /**
     *
     * @param publicacoesRepository $publicacoesRepository
     */
    public function __construct(PublicacoesRepository $publicacoesRepository, UsuarioRepository $usuariosRepository)
    {
        $this->publicacoesRepository = $publicacoesRepository;
        $this->usuariosRepository = $usuariosRepository;
    }

    const USERADM = 1;
    const USERCOMUM = 0;

    const PUBLI_PENDENTES = 1;
    const PUBLI_NAOACEITA = 2;
    const PUBLI_EMABERTO = 3;
    const PUBLI_RESGTANDMT = 4; 
    const PUBLI_RESGTCONCLU = 5; // status do manifestar
    const PUBLI_MANIFESTADA = 6;
    const PUBLI_MANIFESTADACONCLUIDA = 7;
    
    const IMAGENS_PUBLI = 1;
    const IMAGENS_RESGATE = 2;
    
    public function EditarPubliParaResgate(int $id): View
    {
        $item = $this->publicacoesRepository->findById($id);
    
        $categorias_combobox = Categoria::pluck('NOME', 'ID');
        $blocos_combobox = Bloco::pluck('NOME', 'ID');

        return view('/Publicacao/SolicitarResgate', compact('item', 'categorias_combobox', 'blocos_combobox'));
    }
    
    public function VisualizarSolicitacao(){

        $perPage = 10;

        $items = $this->publicacoesRepository->paginateTodasPubliResgate($perPage,self::PUBLI_RESGTANDMT);

        return view('/Publicacao/VisualizarSolicitacao', compact('items'));
    }

    public function SolicitacaoResgateVisualizar(int $id): View
    {
        $item = $this->publicacoesRepository->findByIdResgateImagens($id);

        $resgateIDUSUARIO = DB::table('resgates')->where('IDPUBLICACAO', $id)->value('IDUSUARIO');

        $itemUser = $this->usuariosRepository->findById($resgateIDUSUARIO);

        $nomeUser = $itemUser->nome;
        $CPFUser = $itemUser->cpf;

        $categorias_combobox = Categoria::pluck('NOME', 'ID');
        $blocos_combobox = Bloco::pluck('NOME', 'ID');

        return view('/Publicacao/Visualizar', compact('item', 'categorias_combobox', 'blocos_combobox','nomeUser','CPFUser'));
    }

    public function resgatarPublicacao(Request $request, $id)
    {

        // Realize aqui o processo de resgate da publicação
        // Por exemplo, você pode obter os dados enviados pelo formulário e salvar no banco de dados
        // $request->input('campo') pode ser usado para obter os valores dos campos enviados

        // Salvar o ID da publicação e a data/hora na resgates
        $publicacao = DB::table('publicacoes')->find($id);
        if ($publicacao) {
            $insertId = DB::table('resgates')->insertGetId([
                    'DATAHORA' => now(),
                    'IDUSUARIO' =>  session('user_id'),
                    'IDPUBLICACAO' => $id,
            ]);

            $this->publicacoesRepository->alterStatusPublicacao($id,self::PUBLI_RESGTANDMT);

            // Salvar a imagem na tabela imagens
            $this->NewImagems($request,$insertId);


            return redirect()->route('usuario.telainicial'); // Redirecionar para outra rota após o resgate!
        }

        return redirect()->back()->with('error', 'Publicação não encontrada.'); // Redirecionar de volta à página com uma mensagem de erro, se a publicação não for encontrada
    }


    public function resgatarPublicacaoUpdate(Request $request, $id, $IdResgate)
    {

        $publicacao = $this->publicacoesRepository->findByIdResgateImagens($id);

        if($publicacao) {

            if ($request->hasFile('img')) {

                if ($publicacao->imageNames){
                    foreach ($publicacao->imageNames as $imageName){
                        $this->deleteImage($imageName, $IdResgate); // Excluir as imagens antigas
                    }
                }

                // Salvar as novas imagens na tabela imagens
                $this->NewImagems($request,$IdResgate);
            }

            return redirect()->route('publicacoes.resgateVizualizar');
        }

        return redirect()->back()->with('error', 'Publicação não encontrada.');
    }

    public function deleteImage($imageName, int $id)
    {
        // Excluindo a imagem física do servidor
        $imagePath = public_path('img/events/' . $imageName);
        if (file_exists($imagePath)) {
            unlink($imagePath);
        }

        // Deleta os registros da tabela "imagens_objetos" associados à publicação e com a trigger deleta da tabela "imagens" tbm
        DB::table('imagens_objetos')->where('IDOBJETO_RESGATE', $id)->delete();
    }

    public function NewImagems(Request $request, int $insertId)
    {
            // Verifica se foram enviadas imagens
        if ($request->hasFile('img')) {
                $images = [];
                
                foreach ($request->file('img') as $imageFile) {
                    $imagens = new Imagens;

                    // Salva a imagem no storage e obtém o caminho
                    $path = $imageFile->store('images');

                    $filename = date('YmdHi') . $imageFile->getClientOriginalName();
        
                    $path = public_path('img/events');
                    $imageFile->move($path, $filename);
        
                    $imagens->nome =  $filename;
                    $imagens->caminho =  $path;
                    $imagens->extensao =  $imageFile->getClientOriginalExtension();
        
                    // Salva a imagem no banco de dados
                    $imagens->save();

                    // Salvar o registro na tabela imagens_objeto
                    $this->saveImagemObjeto($imagens->id, $insertId, self::IMAGENS_RESGATE);

                    // Retorna o ID da imagem recém-salva
                    // Adicione o ID da imagem ao array
                    $images[] = $imagens->id;
                }
            
        }else
        {
            // Verificar se a imagem foi salva corretamente
            return redirect()->back()->with('errorC', 'Erro ao salvar a imagem...');
        }
    }

    private function saveImagemObjeto($idImagem, $idObjeto, $tipo)
    {   // Tipo 1  - Imagens Publicacoes
        // Tipo 2 - Imagens Resgate.
        
        $imagensObjeto = new ImagensObjetos;
        $imagensObjeto->IDIMAGEM = $idImagem;

        if($tipo == self::IMAGENS_PUBLI){
            $imagensObjeto->IDOBJETO_PUBLICACOES = $idObjeto;
        }else{
            $imagensObjeto->IDOBJETO_RESGATE = $idObjeto;
        }
    
        $imagensObjeto->TIPO = $tipo; // Defina o valor correto para o tipo de objeto, se necessário
        $imagensObjeto->save();
    }

    public function ResgateEdit(Request $request, $id, $IdResgate)
    {
        $item = $this->publicacoesRepository->findByIdResgateImagens($id);

        $resgateIDUSUARIO = DB::table('resgates')->where('IDPUBLICACAO', $id)->value('IDUSUARIO');

        $itemUser = $this->usuariosRepository->findById($resgateIDUSUARIO);

        $nomeUser = $itemUser->nome;
        $CPFUser = $itemUser->cpf;

        $categorias_combobox = Categoria::pluck('NOME', 'ID');
        $blocos_combobox = Bloco::pluck('NOME', 'ID');
        
        return view('/Publicacao/SolicitarResgateEdit', compact('item', 'categorias_combobox', 'blocos_combobox','nomeUser','CPFUser'));
    }

    public function resgatarPublicacaoCancel(Request $request, $id)
    {
        if ($id){
            DB::table('publicacoes')
                ->where('ID', $id)
                ->update(['STATUS' => self::PUBLI_MANIFESTADACONCLUIDA]); 

            return redirect()->route('usuario.telainicial'); // Redirecionar para mesma rota após a acao
        }
        return redirect()->back()->with('error', 'Publicação/manifestação não encontrada.'); // Redirecionar de volta à página com uma mensagem de erro, se a publicação não for encontrada
    }

    public function resgatarPublicacaoConcluir(Request $request, $id)
    {
        // Salvar o ID da publicação e a data/hora da manifestação
        $publicacao = DB::table('publicacoes')->find($id);

            if ($publicacao) {
                    DB::table('devolvidos')->insert([
                        'DATAHORA' => now(),
                        'IDUSUARIO' =>  session('user_id'),
                        'IDPUBLICACAO' => $id,
                    ]);

                    $this->publicacoesRepository->alterStatusPublicacao($id,self::PUBLI_RESGTCONCLU);

                return redirect()->route('publicacoes.resgateVizualizar'); // Redirecionar para mesma rota após a acao
            }
        return redirect()->back()->with('error', 'Publicação/manifestação não encontrada.'); // Redirecionar de volta à página com uma mensagem de erro, se a publicação não for encontrada
    }

    public function destroy(int $id): RedirectResponse
	{
        // Obter ID do resgate referente a essa publicação
        $resgateID = DB::table('resgates')->where('IDPUBLICACAO', $id)->value('ID');

        $delete = DB::table('resgates')->where('ID', $resgateID)->delete();
		$deleteImgs =  DB::table('imagens_objetos')->where('IDOBJETO_RESGATE', $resgateID)->delete();

		if ((!$delete) && (!$deleteImgs)){
			return redirect()->back()->with('error', 'Erro ao excluir publicação');
		}

        $this->publicacoesRepository->alterStatusPublicacao($id,self::PUBLI_EMABERTO);

        return redirect()->route('publicacoes.resgateVizualizar'); // Redirecionar para mesma rota após a acao
	}


}
