<?php namespace Admin;

trait Translation
{
    public function modelTrait()
    {
        return $this;
    }

    public function table_parent_name()
    {
        return $this->getTable();
    }

    public function table_translation_name()
    {
        $table_translations = str_singular($this->table_parent_name()) . '_translations';

        return $table_translations;
    }

    public function foreign_key()
    {
        $table = $this->table_parent_name();

        $foreignKey = str_singular($table) . '_id';

        return $foreignKey;
    }

    public function default_field_parents()
    {
        $fields = \DB::getSchemaBuilder()->getColumnListing($this->table_parent_name());
        $data   = [];
        foreach ($fields as $field) {
            $data[] = $this->table . '.' . $field;
        }

        return $data;
    }

    public function field_translations()
    {
        return \DB::getSchemaBuilder()->getColumnListing($this->table_translation_name());
    }

    public function default_field_translations()
    {
        $except = ['id', 'created_at', 'updated_at'];

        $fields = array_diff($this->field_translations(), $except);

        $data = [];
        foreach ($fields as $field) {
            $data[] = $this->table_translation_name() . '.' . $field;
        }

        return $data;
    }

    public function default_fields()
    {
        return array_merge($this->default_field_parents(), $this->default_field_translations());
    }

    public function scopeMergeTranslation($query)
    {
        $table = $this->table_parent_name();

        $table_translations = $this->table_translation_name();

        $foreign_key = $this->foreign_key();

        $field_translations = $this->default_fields();

        $result = $query
            ->select($field_translations)
            ->join($table_translations, $table_translations . '.' . $foreign_key, '=', $table . '.id');

        return $result;
    }
}
