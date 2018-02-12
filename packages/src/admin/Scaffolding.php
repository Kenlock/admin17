<?php namespace Admin;

use Table;

trait Scaffolding
{

    public function model()
    {
        return new \App\Models\Crud();
    }

    public function hide_default_fields()
    {
        return ['created_at', 'updated_at'];
    }

    public function hide_default_field_form()
    {
        return ['id','slug','created_at','updated_at'];
    }

    public function default_table_fields()
    {
        $from_table = $this->fields_from_table();
        return array_diff($from_table, $this->hide_default_fields());
    }

    public function default_form_fields()
    {
        $from_table = $this->fields_from_table();
        return array_diff($from_table, $this->hide_default_field_form());
    }

    public function table_fields()
    {
        $default_fields = $this->default_table_fields();
        $headers        = [];
        $records        = [];

        foreach ($default_fields as $field) {
            $headers[] = ucwords(str_replace("_", " ", $field));
            $records[] = ['data' => $field, 'name' => $field];
        }
        // add action
        $headers = array_merge($headers, ['Action']);
        $records = array_merge($records, [['data' => 'action', 'name' => 'action', 'searchable' => false, 'orderable' => false]]);
        //

        return [
            'headers' => $headers,
            'records' => $records,
        ];
    }

    public function table_headers()
    {
        $fields = $this->table_fields();

        $result_properties = "";
        $th                = "";
        foreach ($fields['headers'] as $label => $properties) {
            if (!is_numeric($label)) {
                $html = "";
                foreach ($properties as $key => $val) {
                    $html .= "$key = '$val' ";
                }

                $result_properties = $html;

            }

            $result_label = is_numeric($label) ? $properties : $label;

            $th .= "<th $result_properties>" . $result_label . "</th>";
        }

        return $th;
    }

    public function only_name_fields()
    {
        $records = $this->table_fields()['records'];
        $name    = [];
        foreach ($records as $row) {
            $name[] = $row['name'];
        }
        return $name;
    }

    public function fields_from_table()
    {
        $table = $this->model()->getTable();
        return \DB::getSchemaBuilder()->getColumnListing($table);
    }

    public function match_fields_to_table()
    {
        $columnFromTable = $this->fields_from_table();
        $columnFromName  = $this->only_name_fields();
        return array_intersect($columnFromTable, $columnFromName);
    }

    public function query_data_tables()
    {
        $model = $this->model()->select($this->default_table_fields());

        return Table::of($model)
            ->addColumn('action', function ($model) {
                $hidden = \Form::hidden('id[]', $model->id);
                return $hidden . admin()->html->linkActions($model);
            })
            ->make(true);
    }

    public function getData()
    {
        return $this->query_data_tables();
    }

    public function table_records()
    {
        $records = $this->table_fields()['records'];

        return json_encode($records);
    }

    public function rowOrder()
    {
        $table_fields = $this->table_fields();

        return $row_order = !empty($table_fields['row_order']) ? $table_fields['row_order'] : 'false';
    }

    public function getIndex()
    {
        return $this->makeView('index', [
            'table_headers' => $this->table_headers(),
            'columns'       => $this->table_records(),
            'row_order'     => $this->rowOrder(),
        ]);
    }

    public function makeView($view, $data = [])
    {
        return view('admin.scaffolding.' . $view, $data);
    }

    public function form()
    {
        $fields = $this->default_form_fields();
        $data   = [];
        foreach ($fields as $field) {
            $data[$field] = [
                'label'      => ucwords(str_replace("_", " ", $field)),
                'type'       => 'text',
                'attributes' => [
                    'class' => 'form-control',
                ],
            ];
        }
        return $data;
    }

    public function form_text($model, $name, $prop)
    {
        $attributes = !empty($prop['attributes']) ? $prop['attributes'] : [];
        $value      = empty($prop['value']) ? @$model->$name : $prop['value'];
        $multi      = @$prop['multi_language'];
        $result     = "";
        if ($multi == true) {
            foreach (languages() as $key => $val) {
                $result .= "<div class = 'multi_language_$key' style = 'margin-bottom:10px;' >";
                $result .= \Form::label(ucwords($prop['label']));

                $value = @$prop['value'];
                if (empty($prop['value'])) {
                    if (method_exists(@$model, 'translate') == true) {
                        $value = @$model->translate($key)->$name;
                    } else {
                        $value = @$model->$key->$name;
                    }
                }

                $result .= \Form::text($key . "[$name]", $value, $attributes);
                $result .= "</div>";
            }
        } else {
            $result .= \Form::label(ucwords($prop['label']));
            $result .= \Form::text($name, $value, $attributes);
        }

        return $result;
    }

    public function form_textarea($model, $name, $prop)
    {
        $attributes = !empty($prop['attributes']) ? $prop['attributes'] : [];
        $value      = empty($prop['value']) ? @$model->$name : $prop['value'];
        $multi      = @$prop['multi_language'];
        $result     = "";
        if ($multi == true) {
            foreach (languages() as $key => $val) {
                $result .= "<div class = 'multi_language_$key' style = 'margin-bottom:10px;' >";
                $result .= \Form::label(ucwords($prop['label']));

                $value = @$prop['value'];
                if (empty($prop['value'])) {
                    if (method_exists(@$model, 'translate') == true) {
                        $value = @$model->translate($key)->$name;
                    } else {
                        $value = @$model->$key->$name;
                    }
                }

                $result .= \Form::textarea($key . "[$name]", $value, $attributes);
                $result .= "</div>";
            }
        } else {
            $result .= \Form::label(ucwords($prop['label']));
            $result .= \Form::textarea($name, $value, $attributes);
        }

        return $result;
    }

    public function form_image($model, $name, $prop)
    {
        $attributes = !empty($prop['attributes']) ? $prop['attributes'] : [];
        $value      = @$model->{$name};
        $slot       = $name;
        $file       = \Form::label(ucwords(@$prop['label']));
        $file .= \Form::file($slot, ['class' => 'form-control', 'id' => $slot, 'onchange' => "with_preview('" . $slot . "')"]);
        $file .= admin()->html->size_recomendation(@$prop['size_recomendation']);
        $html = $file;
        if (!empty($value)) {
            $html .= '<div id="div_preview_' . $slot . '"><p>&nbsp;</p>';
            $html .= '<img class="img-thumbnail" src="' . asset('contents/' . $value) . '"  width="200" height="200" id="image_preview_' . $slot . '"><br/>';
            $html .= '<br/>';
            $html .= '<a href="javascript:void(0);" onclick="removePreview(\'' . $name . '\')">Remove</a>';
            $html .= '<input type="hidden" name="hidden_' . $slot . '" value = "true"/>';
            $html .= '</div>';
        }
        $html .= \Form::hidden('old_' . $name, $value);
        return $html;

    }

    public function form_status($model, $name, $prop)
    {
        $name = 'status';
        $prop = [
            'label'      => 'Status',
            'data'       => [
                'publish' => 'Publish',
                'draft'   => 'Draft',
            ],
            'attributes' => [
                'class' => 'form-control',
            ],
        ];
        return $this->form_select($model, $name, $prop);
    }

    public function form_select($model, $name, $prop)
    {
        $attributes = !empty($prop['attributes']) ? $prop['attributes'] : [];
        $value      = empty($prop['value']) ? @$model->$name : $prop['value'];
        $multi      = @$prop['multi_language'];
        $result     = "";
        if ($multi == true) {
            foreach (languages() as $key => $val) {
                $result .= "<div class = 'multi_language_$key' style = 'margin-bottom:10px;'>";
                $result .= \Form::label(ucwords($prop['label']));
                $result .= \Form::select($key . "[$name]", @$prop['data'], $value, $attributes);
                $result .= "</div>";
            }

        } else {
            $result .= \Form::label(ucwords($prop['label']));
            $result .= \Form::select($name, @$prop['data'], $value, $attributes);
        }
        return $result;
    }

    public function manipulate_forms($model)
    {
        $forms = $this->form();
        $html  = "";

        foreach ($forms as $name => $prop) {
            $type              = !empty($prop['type']) ? $prop['type'] : 'text';
            $manipulate_method = "form_" . $type;
            $html .= "<div class='form-group'>";
            $html .= $this->$manipulate_method($model, $name, $prop);
            $html .= "</div>";
        }
        return $html;

    }

    public function manipulate_rules()
    {
        $forms      = $this->form();
        $validation = [];
        foreach ($forms as $key => $val) {
            if (!is_numeric($key)) {
                $multi = @$val['multi_language'];
                $rules = @$val['validation']['rules'];
                if (!empty($val['validation']['rules'])) {
                    if ($multi == true) {
                        foreach (languages() as $lang => $lang_val) {
                            $validation[$lang . '.' . $key] = $rules;
                        }
                    } else {
                        $validation[$key] = $rules;
                    }
                }
            }
        }

        return $validation;
    }

    public function manipulate_rule_messages()
    {
        $forms      = $this->form();
        $validation = [];
        foreach ($forms as $key => $val) {
            if (!is_numeric($key)) {
                if (!empty($val['validation']['messages'])) {
                    $validation += $val['validation']['messages'];
                }
            }
        }
        return $validation;
    }

    public function getCreate()
    {
        $validation = \JsValidator::make($this->manipulate_rules(), $this->manipulate_rule_messages());
        return $this->makeView('_form', [
            'model'      => $this->model(),
            'inputs'     => $this->manipulate_forms($this->model()),
            'validation' => $validation,
        ]);
    }

    public function postCreate()
    {
        $inputs     = request()->all();
        $validation = \Validator::make(request()->all(), $this->manipulate_rules());

        if ($validation->fails()) {
            return redirect()->back()->withErrors($validation->errors());
        }

        return $this->create($this->model(), $inputs);
    }

    public function getUpdate($id)
    {
        $validation = \JsValidator::make($this->manipulate_rules(), $this->manipulate_rule_messages());
        $model      = $this->model()->findOrFail($id);
        return $this->makeView('_form', [
            'model'      => $model,
            'inputs'     => $this->manipulate_forms($model),
            'validation' => $validation,
        ]);
    }

    public function postUpdate($id)
    {
        $inputs     = request()->all();
        $validation = \Validator::make(request()->all(), $this->manipulate_rules());
        $model      = $this->model()->findOrFail($id);

        if ($validation->fails()) {
            return redirect()->back()->withErrors($validation->errors());
        }

        return $this->update($model, $inputs);
    }

    public function getDelete($id)
    {
        return $this->delete($this->model()->findOrFail($id));
    }

    public function getActionBool($id)
    {
        return $this->publish_draft($this->model()->findOrFail($id));
    }

    public function getUpdateOrder()
    {
        return $this->update_order($this->model());
    }
}
