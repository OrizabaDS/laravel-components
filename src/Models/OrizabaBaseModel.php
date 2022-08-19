<?php

namespace OrizabaEis\LaravelComponents\Models;


use Illuminate\Database\Eloquent\Model;


class OrizabaBaseModel extends Model
{
    protected function beforeFill(array $attributes): array
    {
        return $attributes;
    }


    public function save(array $options = [])
    {
        $attributes = $this->beforeFill($this->getAttributes());

        $this->fill($attributes);

        return parent::save($options);
    }

}