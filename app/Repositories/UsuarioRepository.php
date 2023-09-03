<?php

namespace App\Repositories;

use App\Models\User;
use Spatie\QueryBuilder\AllowedFilter;
use Spatie\QueryBuilder\QueryBuilder;

class UsuarioRepository
{
    /**
     *
     * @var User
     */
    private $model;

    /**
     *
     * @param User $model
     */
    public function __construct(User $model)
    {
        $this->model = $model;
    }

    /**
     *
     * @param integer $id
     * @return User|null
     */
    public function findById(int $id): ?User {
        $usuario = QueryBuilder::for(User::class)
            ->where('ID', $id)
            ->first();

        return $usuario;
    }

    /**
     * Criar um recurso
     *
     * @param array $data
     * @return User
     */
    public function store(array $data): User {
        try {
            return $this->model->create($data);
        } catch (\Exception $e) {
            // Exibir ou registrar o erro para depuração
            dd($e->getMessage());
        }
    }

    /**
     *
     * @param integer $id
     * @param array $data
     * @return bool
     */
    public function update(int $id, array $data): bool {
        $usuario = $this->findById($id);

        if(!$usuario) {
            return false;
        }

        return $usuario->update($data);
    }

    /**
     *
     * @param integer $id
     * @return boolean
     */
    public function delete(int $id): bool {
        $usuario = $this->findById($id);

        if(!$usuario) {
            return false;
        }

        return $usuario->delete();
    }
}