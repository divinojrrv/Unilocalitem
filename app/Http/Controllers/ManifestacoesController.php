<?php

namespace App\Http\Controllers;


use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use App\Models\Bloco;
use App\Models\Categoria;
use App\Models\Publicacoes;
use App\Models\Resgate;
use App\Models\User;
use App\Models\Manifestacoes;
use App\Repositories\PublicacoesRepository;
use Illuminate\Http\Request;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Hash;
use App\Http\Requests\RegisterUsuariosRequest;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Validator;



class ManifestacoesController extends Controller
{
   /**
     *
     * @var PublicacoesRepository
     */
    private $publicacoesRepository;

    /**
     *
     * @param publicacoesRepository $publicacoesRepository
     */
    public function __construct(PublicacoesRepository $publicacoesRepository)
    {
        $this->publicacoesRepository = $publicacoesRepository;

    }

    const USERADM = 1;
    const USERCOMUM = 0;
    
    const PUBLI_PENDENTES = 1;
    const PUBLI_NAOACEITA = 2;
    const PUBLI_EMABERTO = 3;
    const PUBLI_RESGTANDMT= 4; 
    const PUBLI_RESGTCONCLU = 5; // status do manifestar
    const PUBLI_MANIFESTADA = 6;
    const PUBLI_MANIFESTADACONCLUIDA = 7;

    public function ManifestacoesPublicacoes(){

		$perPage = 10;

        if (session('user_tipousuario') == self::USERADM) {
            $items = $this->publicacoesRepository->paginateTodasPubli($perPage,self::PUBLI_RESGTCONCLU);
        } else {
            $items = $this->publicacoesRepository->paginateExcluindoUser($perPage,self::PUBLI_RESGTCONCLU,session('user_id'));
        }

        return view('/Publicacao/ManifestacoesPublicacoes', compact('items'));
    }

    public function Manifestadas(){

        $perPage = 10;

        if (session('user_tipousuario') == self::USERADM) {
            $items = $this->publicacoesRepository->paginateTodasPubliManifestadas($perPage,self::PUBLI_MANIFESTADA);
            return view('/Publicacao/Manifestadas', compact('items'));
        } else {
            $items = $this->publicacoesRepository->paginatePorUserManifestadas($perPage,self::PUBLI_MANIFESTADACONCLUIDA,session('user_id'));
            return view('/Publicacao/ManifestadasUserComum', compact('items'));
        }
    }
    public function devolucoes(){

        $perPage = 10;

        if (session('user_tipousuario') == self::USERADM) {
            $items = $this->publicacoesRepository->paginateTodasPubliManifestadas($perPage,self::PUBLI_RESGTCONCLU);
            return view('/Publicacao/devolucoes', compact('items'));
        }
    }


    public function manifestarPublicacao(Request $request, $id)
    {

        $publicacao = DB::table('publicacoes')->find($id);
        if ($publicacao) {
                DB::table('manifestacoes')->insert([
                    'DATAHORA' => now(),
                    'IDUSUARIO' =>  session('user_id'),
                    'IDPUBLICACAO' => $id,
            ]);

            $this->publicacoesRepository->alterStatusPublicacao($id,self::PUBLI_MANIFESTADA);

            return redirect()->route('manifestacoes.manifestadas'); 
        }

        return redirect()->back()->with('error', 'Publicação não encontrada.'); 
    }

    public function manifestaAceitar(Request $request, $id)
    {
        if ($id){
            DB::table('publicacoes')
                ->where('ID', $id)
                ->update(['STATUS' => self::PUBLI_MANIFESTADACONCLUIDA]); 

            return redirect()->route('manifestacoes.manifestadas'); 
        }
        return redirect()->back()->with('error', 'Publicação/manifestação não encontrada.'); 
    }

    public function manifestaRecusar(Request $request, $id)
    {
        $manifestacoes = DB::table('manifestacoes')->where('IDPUBLICACAO', $id)->delete();

        if ($manifestacoes) {

            DB::table('publicacoes')
                ->where('ID', $id)
                ->update(['STATUS' => self::PUBLI_RESGTCONCLU]);

            return redirect()->route('manifestacoes.manifestadas'); 
        }
        return redirect()->back()->with('error', 'Publicação/manifestação não encontrada.'); 
    }
}
