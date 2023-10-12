<?php

namespace App\Repositories;

use App\Models\Publicacoes;
use App\Models\Manifestacoes;
use Illuminate\Pagination\LengthAwarePaginator;
use App\Utils\Filters\LowerThanFilter;
use Spatie\QueryBuilder\AllowedFilter;
use Spatie\QueryBuilder\QueryBuilder;
use Illuminate\Support\Facades\DB;

class PublicacoesRepository
{
    /**
     *
     * @var Publicacoes
     */
    private $model;

    /**
     *
     * @param Publicacoes $model
     */
    public function __construct(Publicacoes $model)
    {
        $this->model = $model;
    }




    // public function paginate(int $perPage): LengthAwarePaginator {
    //     $vehicles = QueryBuilder::for(Vehicle::class)
    //         ->allowedFilters([
    //             'name',
    //             'brand',
    //             AllowedFilter::custom('vehicle_year', new LowerThanFilter),
    //             AllowedFilter::custom('kilometers', new LowerThanFilter),
    //             AllowedFilter::custom('price', new LowerThanFilter),
    //             'city',
    //             'type',
    //         ])
    //         ->paginate($perPage);

    //     return $vehicles;
    // }

    
     public function paginatePorUser(int $perPage, int $status, int $idusuario): LengthAwarePaginator {

            $publicacoes = QueryBuilder::for(Publicacoes::class)
            ->where('STATUS', $status)
            ->where('IDUSUARIO', $idusuario)
            ->paginate($perPage);


        // Obter informações das imagens associadas a cada publicação
        foreach ($publicacoes as $publicacao) {
            $imageId = DB::table('imagens_objetos')->where('IDOBJETO_PUBLICACOES', $publicacao->ID)->value('IDIMAGEM');
            $imageName = $this->getColumnValueById('imagens','NOME',$imageId);
            $UserName = $this->getColumnValueById('users','NOME',$publicacao->IDUSUARIO);
            $CategoriaName = $this->getColumnValueById('categorias','NOME',$publicacao->IDCATEGORIA);
            $BlocoName = $this->getColumnValueById('blocos','NOME',$publicacao->IDBLOCO);

            $publicacao->image = $imageName;
            $publicacao->UserName = $UserName;
            $publicacao->CategoriaName = $CategoriaName;
            $publicacao->BlocoName = $BlocoName;
        }

        return $publicacoes;
    }

        
    public function paginatePorUserManifestadas(int $perPage, int $status, int $idusuario): LengthAwarePaginator {


            $publicacoes = DB::table('publicacoes as p')
            ->join('manifestacoes as m', 'p.ID', '=', 'm.IDPUBLICACAO')
            ->where('p.STATUS', $status)
            ->where('m.IDUSUARIO', $idusuario)
            ->select('p.*',    
                     'm.IDUSUARIO as ManifestacaoIdUsuario',
                     'm.DATAHORA as manifestacaoDATAHORA')
            ->paginate($perPage);



        // Obter informações das imagens associadas a cada publicação
        foreach ($publicacoes as $publicacao) {
            
            $resgateIDUSUARIO = DB::table('resgates')->where('IDPUBLICACAO', $publicacao->ID)->value('IDUSUARIO');
            $resgateDATAHORA = DB::table('resgates')->where('IDPUBLICACAO', $publicacao->ID)->value('DATAHORA');

            $devolvidoIDUSUARIO = DB::table('devolvidos')->where('IDPUBLICACAO', $publicacao->ID)->value('IDUSUARIO');
            $devolvidoDATAHORA = DB::table('devolvidos')->where('IDPUBLICACAO', $publicacao->ID)->value('DATAHORA');

            $imageId = DB::table('imagens_objetos')->where('IDOBJETO_PUBLICACOES', $publicacao->ID)->value('IDIMAGEM');
            $imageName = $this->getColumnValueById('imagens','NOME',$imageId);
            $UserName = $this->getColumnValueById('users','NOME',$publicacao->IDUSUARIO);
            $CategoriaName = $this->getColumnValueById('categorias','NOME',$publicacao->IDCATEGORIA);
            $BlocoName = $this->getColumnValueById('blocos','NOME',$publicacao->IDBLOCO);

            $ManifestadoName = $this->getColumnValueById('users','nome',$publicacao->ManifestacaoIdUsuario);
            $ResgateName = $this->getColumnValueById('users','nome',$resgateIDUSUARIO);
            $DevolvidoName = $this->getColumnValueById('users','nome',$devolvidoIDUSUARIO);

            $publicacao->ManifestadoName = $ManifestadoName;
            //DATAHORA -> manifestacaoDATAHORA

            $publicacao->ResgateName = $ResgateName;
            $publicacao->resgateDATAHORA = $resgateDATAHORA;

            $publicacao->DevolvidoName = $DevolvidoName;
            $publicacao->devolvidoDATAHORA = $devolvidoDATAHORA;


            $publicacao->image = $imageName;
            $publicacao->UserName = $UserName;
            $publicacao->CategoriaName = $CategoriaName;
            $publicacao->BlocoName = $BlocoName;


        }

        return $publicacoes;
    }

    public function paginateTodasPubliManifestadas(int $perPage, int $status): LengthAwarePaginator {

             $publicacoes = QueryBuilder::for(Publicacoes::class)
             ->whereIn('STATUS', [$status, 7])
             ->paginate($perPage);


        // Obter informações das imagens associadas a cada publicação
        foreach ($publicacoes as $publicacao) {

            $resgateIDUSUARIO = DB::table('resgates')->where('IDPUBLICACAO', $publicacao->ID)->value('IDUSUARIO');
            $resgateDATAHORA = DB::table('resgates')->where('IDPUBLICACAO', $publicacao->ID)->value('DATAHORA');

            $devolvidoIDUSUARIO = DB::table('devolvidos')->where('IDPUBLICACAO', $publicacao->ID)->value('IDUSUARIO');
            $devolvidoDATAHORA = DB::table('devolvidos')->where('IDPUBLICACAO', $publicacao->ID)->value('DATAHORA');

            $manifestacaoIDUSUARIO = DB::table('manifestacoes')->where('IDPUBLICACAO', $publicacao->ID)->value('IDUSUARIO');
            $manifestacaoDATAHORA = DB::table('manifestacoes')->where('IDPUBLICACAO', $publicacao->ID)->value('DATAHORA');

            $imageId = DB::table('imagens_objetos')->where('IDOBJETO_PUBLICACOES', $publicacao->ID)->value('IDIMAGEM');
            $imageName = $this->getColumnValueById('imagens','NOME',$imageId);
            $UserName = $this->getColumnValueById('users','NOME',$publicacao->IDUSUARIO);
            $CategoriaName = $this->getColumnValueById('categorias','NOME',$publicacao->IDCATEGORIA);
            $BlocoName = $this->getColumnValueById('blocos','NOME',$publicacao->IDBLOCO);

            $ManifestadoName = $this->getColumnValueById('users','nome',$manifestacaoIDUSUARIO);
            $ResgateName = $this->getColumnValueById('users','nome',$resgateIDUSUARIO);
            $DevolvidoName = $this->getColumnValueById('users','nome',$devolvidoIDUSUARIO);

            $publicacao->ManifestadoName = $ManifestadoName;
            $publicacao->manifestacaoDATAHORA = $manifestacaoDATAHORA;

            $publicacao->ResgateName = $ResgateName;
            $publicacao->resgateDATAHORA = $resgateDATAHORA;

            $publicacao->DevolvidoName = $DevolvidoName;
            $publicacao->devolvidoDATAHORA = $devolvidoDATAHORA;

            $publicacao->image = $imageName;
            $publicacao->UserName = $UserName;
            $publicacao->CategoriaName = $CategoriaName;
            $publicacao->BlocoName = $BlocoName;
        }

        return $publicacoes;
    }

    public function paginateExcluindoUser(int $perPage, int $status, int $idusuario): LengthAwarePaginator {
        $publicacoes = QueryBuilder::for(Publicacoes::class)
            ->where('STATUS', $status)
            ->where('IDUSUARIO','!=', $idusuario)
            ->paginate($perPage);

       // Obter informações das imagens associadas a cada publicação
       foreach ($publicacoes as $publicacao) {

            $resgateIDUSUARIO = DB::table('resgates')->where('IDPUBLICACAO', $publicacao->ID)->value('IDUSUARIO');
            $resgateDATAHORA = DB::table('resgates')->where('IDPUBLICACAO', $publicacao->ID)->value('DATAHORA');

            $devolvidoIDUSUARIO = DB::table('devolvidos')->where('IDPUBLICACAO', $publicacao->ID)->value('IDUSUARIO');
            $devolvidoDATAHORA = DB::table('devolvidos')->where('IDPUBLICACAO', $publicacao->ID)->value('DATAHORA');

            $manifestacaoIDUSUARIO = DB::table('manifestacoes')->where('IDPUBLICACAO', $publicacao->ID)->value('IDUSUARIO');
            $manifestacaoDATAHORA = DB::table('manifestacoes')->where('IDPUBLICACAO', $publicacao->ID)->value('DATAHORA');

           $imageId = DB::table('imagens_objetos')->where('IDOBJETO_PUBLICACOES', $publicacao->ID)->value('IDIMAGEM');
           $imageName = $this->getColumnValueById('imagens','NOME',$imageId);
           $UserName = $this->getColumnValueById('users','NOME',$publicacao->IDUSUARIO);
           $CategoriaName = $this->getColumnValueById('categorias','NOME',$publicacao->IDCATEGORIA);
           $BlocoName = $this->getColumnValueById('blocos','NOME',$publicacao->IDBLOCO);

           $ManifestadoName = $this->getColumnValueById('users','nome',$manifestacaoIDUSUARIO);
           $ResgateName = $this->getColumnValueById('users','nome',$resgateIDUSUARIO);
           $DevolvidoName = $this->getColumnValueById('users','nome',$devolvidoIDUSUARIO);

           $publicacao->ManifestadoName = $ManifestadoName;
           $publicacao->manifestacaoDATAHORA = $manifestacaoDATAHORA;

           $publicacao->ResgateName = $ResgateName;
           $publicacao->resgateDATAHORA = $resgateDATAHORA;

           $publicacao->DevolvidoName = $DevolvidoName;
           $publicacao->devolvidoDATAHORA = $devolvidoDATAHORA;

           $publicacao->image = $imageName;
           $publicacao->UserName = $UserName;
           $publicacao->CategoriaName = $CategoriaName;
           $publicacao->BlocoName = $BlocoName;
       }

       return $publicacoes;
   }

   public function paginateTodasPubliResgate(int $perPage, int $status): LengthAwarePaginator {

        $publicacoes = QueryBuilder::for(Publicacoes::class)
        ->where('STATUS', $status)
        ->paginate($perPage);

    // Obter informações das imagens associadas a cada publicação
        foreach ($publicacoes as $publicacao) {
            $imageId = DB::table('imagens_objetos')->where('IDOBJETO_PUBLICACOES', $publicacao->ID)->value('IDIMAGEM');
            $imageName = $this->getColumnValueById('imagens','NOME',$imageId);
            $UserName = $this->getColumnValueById('users','NOME',$publicacao->IDUSUARIO);
            $CategoriaName = $this->getColumnValueById('categorias','NOME',$publicacao->IDCATEGORIA);
            $BlocoName = $this->getColumnValueById('blocos','NOME',$publicacao->IDBLOCO);
            $resgateID = DB::table('resgates')->where('IDPUBLICACAO', $publicacao->ID)->value('ID');

            $publicacao->image = $imageName;
            $publicacao->UserName = $UserName;
            $publicacao->CategoriaName = $CategoriaName;
            $publicacao->BlocoName = $BlocoName;
            $publicacao->IdResgate = $resgateID;
        }

        return $publicacoes;
    }

     public function paginateTodasPubli(int $perPage, int $status): LengthAwarePaginator {

            $publicacoes = QueryBuilder::for(Publicacoes::class)
            ->where('STATUS', $status)
            ->paginate($perPage);

        // Obter informações das imagens associadas a cada publicação
        foreach ($publicacoes as $publicacao) {

            $resgateIDUSUARIO = DB::table('resgates')->where('IDPUBLICACAO', $publicacao->ID)->value('IDUSUARIO');
            $resgateDATAHORA = DB::table('resgates')->where('IDPUBLICACAO', $publicacao->ID)->value('DATAHORA');

            $devolvidoIDUSUARIO = DB::table('devolvidos')->where('IDPUBLICACAO', $publicacao->ID)->value('IDUSUARIO');
            $devolvidoDATAHORA = DB::table('devolvidos')->where('IDPUBLICACAO', $publicacao->ID)->value('DATAHORA');

            $manifestacaoIDUSUARIO = DB::table('manifestacoes')->where('IDPUBLICACAO', $publicacao->ID)->value('IDUSUARIO');
            $manifestacaoDATAHORA = DB::table('manifestacoes')->where('IDPUBLICACAO', $publicacao->ID)->value('DATAHORA');

            $imageId = DB::table('imagens_objetos')->where('IDOBJETO_PUBLICACOES', $publicacao->ID)->value('IDIMAGEM');
            $imageName = $this->getColumnValueById('imagens','NOME',$imageId);
            $UserName = $this->getColumnValueById('users','NOME',$publicacao->IDUSUARIO);
            $CategoriaName = $this->getColumnValueById('categorias','NOME',$publicacao->IDCATEGORIA);
            $BlocoName = $this->getColumnValueById('blocos','NOME',$publicacao->IDBLOCO);

            $ManifestadoName = $this->getColumnValueById('users','nome',$manifestacaoIDUSUARIO);
            $ResgateName = $this->getColumnValueById('users','nome',$resgateIDUSUARIO);
            $DevolvidoName = $this->getColumnValueById('users','nome',$devolvidoIDUSUARIO);

            $publicacao->ManifestadoName = $ManifestadoName;
            $publicacao->manifestacaoDATAHORA = $manifestacaoDATAHORA;

            $publicacao->ResgateName = $ResgateName;
            $publicacao->resgateDATAHORA = $resgateDATAHORA;

            $publicacao->DevolvidoName = $DevolvidoName;
            $publicacao->devolvidoDATAHORA = $devolvidoDATAHORA;

            $publicacao->image = $imageName;
            $publicacao->UserName = $UserName;
            $publicacao->CategoriaName = $CategoriaName;
            $publicacao->BlocoName = $BlocoName;
        }

        return $publicacoes;
    }

    // Método para obter o valor de uma coluna pelo ID da tabela
    public function getColumnValueById($tableName, $column, $id)
    {
        return DB::table($tableName)->where('ID', $id)->value($column);
    }

    /**
     *
     * @param integer $id
     * @return Publicacoes
     */
    public function findById(int $id): Publicacoes {
        $publicacoes = QueryBuilder::for(Publicacoes::class)
            ->where('ID', $id)
            ->first();

        // Obter informações das imagens associadas a cada publicação
        $imageId = DB::table('imagens_objetos')->where('IDOBJETO_PUBLICACOES', $publicacoes->ID)->value('IDIMAGEM');
        $imageName = $this->getColumnValueById('imagens','NOME',$imageId);
        $publicacoes->imageName = $imageName;

        return $publicacoes;
    }

    public function findByIdResgateImagens(int $id): Publicacoes {
        $publicacoes = QueryBuilder::for(Publicacoes::class)
            ->where('ID', $id)
            ->first();

        // Obter informações das imagens associadas a cada publicação no RESGATE
        $resgateID = DB::table('resgates')->where('IDPUBLICACAO', $id)->value('ID');

        $imageIds = DB::table('imagens_objetos')->where('IDOBJETO_RESGATE', $resgateID)->pluck('IDIMAGEM');
        $imageNames = [];

        foreach ($imageIds as $imageId) {
            $imageName = $this->getColumnValueById('imagens', 'NOME', $imageId);
            $imageNames[] = $imageName;

        }
        
        $publicacoes->IdResgate = $resgateID;
        $publicacoes->imageNames = $imageNames;
        
        return $publicacoes;
    }
    
    public function Consultar($dataInicio, $dataFinal, $categoria, $bloco, $status, int $idusuario, int $tipousario) {

        $query = Publicacoes::query();

        if (!empty($dataInicio)) {
            $query->where('publicacoes.DATAHORA', '>=', $dataInicio);
        }

        if (!empty($dataFinal)) {
            $query->where('publicacoes.DATAHORA', '<=', $dataFinal);
        }

        if (!empty($categoria)) {
            $query->where('IDCATEGORIA', $categoria);
        }

        if (!empty($bloco)) {
            $query->where('IDBLOCO', $bloco);
        }

        if (!empty($status)) {

            if($status === '1'){
                if ($tipousario == 0) {
                    $query->where('IDUSUARIO', $idusuario);
                }
            }
            elseif($status === '2'){
                if ($tipousario == 0) {
                    $query->where('IDUSUARIO', $idusuario);
                }
            }
            elseif($status === '3'){
                if ($tipousario == 0) {
                    $query->where('IDUSUARIO','!=', $idusuario);
                }
            }
            elseif($status === '4'){
                //Só adm ver então não tem regra
            }
            elseif($status === '5'){
                if ($tipousario == 0) {
                    $query->where('IDUSUARIO','!=', $idusuario);
                }
            }
            elseif(($status === '6') or ($status === '7')){

                if ($tipousario == 0) {
                    $query->join('manifestacoes as m', 'publicacoes.ID', '=', 'm.IDPUBLICACAO');
                    $query->where('m.IDUSUARIO', $idusuario);
                    
                    if($status === '6'){
                        $query->where('publicacoes.STATUS', $status);
                    }

                }elseif($tipousario == 1){
                    $query->where('STATUS', 7);
                }

                $query->select('publicacoes.*');

            }

            $query->where('STATUS', $status);
        }

        $publicacoes = $query->select(
            '*',
            DB::raw("'valor_extra_1' AS image"),
            DB::raw("'valor_extra_2' AS UserName"),
            DB::raw("'valor_extra_3' AS CategoriaName"),
            DB::raw("'valor_extra_4' AS BlocoName"),
            DB::raw("'valor_extra_5' AS IdResgate")
        )->get();

    // Obter informações das imagens associadas a cada publicação
    foreach ($publicacoes as $publicacao) {
        $imageId = DB::table('imagens_objetos')->where('IDOBJETO_PUBLICACOES', $publicacao->ID)->value('IDIMAGEM');
        $imageName = $this->getColumnValueById('imagens','NOME',$imageId);
        $UserName = $this->getColumnValueById('users','NOME',$publicacao->IDUSUARIO);
        $CategoriaName = $this->getColumnValueById('categorias','NOME',$publicacao->IDCATEGORIA);
        $BlocoName = $this->getColumnValueById('blocos','NOME',$publicacao->IDBLOCO);
        $IdResgate = DB::table('resgates')->where('IDPUBLICACAO', $publicacao->ID)->value('ID');

        $publicacao->image = $imageName;
        $publicacao->UserName = $UserName;
        $publicacao->CategoriaName = $CategoriaName;
        $publicacao->BlocoName = $BlocoName;
        $publicacao->IdResgate = $IdResgate;
    }

    return $publicacoes;
}
    /**
     * Criar um recurso
     *
     * @param array $data
     * @return Publicacoes
     */
    public function store(array $data): Publicacoes {
        return $this->model->create($data);
    }

    /**
     *
     * @param integer $id
     * @param array $data
     * @return bool
     */
    public function update(int $id, array $data): bool {
        $publicacoes = $this->findById($id);

        if(!$publicacoes) {
            return false;
        }

        //retirar o nome da imagem que tava mostrando na tela do edit para não dar erro ao salvar.
        unset($publicacoes->imageName);

        return $publicacoes->update($data);
    }

    /**
     *
     * @param integer $id
     * @return boolean
     */
    public function delete(int $id): bool {
        $publicacoes = $this->findById($id);

        if(!$publicacoes) {
            return false;
        }

        // Deleta os registros da tabela "imagens_objetos" associados à publicação e com a trigger deleta da tabela "imagens" tbm
        $this->deletePublicacaoImages($id);

        // Deleta a publicação
        return $publicacoes->delete();
    }

    /**
     * Deleta os registros da tabela "imagens_objetos" associados à publicação.
     *
     * @param integer $id
     * @return void
     */
    public function deletePublicacaoImages(int $id): void
    {
        DB::table('imagens_objetos')->where('IDOBJETO_PUBLICACOES', $id)->delete();
    }

    public function alterStatusPublicacao(int $id, int $status): void
    {
        DB::table('publicacoes')->where('ID', $id)->update(['STATUS' => $status]);
    }
}