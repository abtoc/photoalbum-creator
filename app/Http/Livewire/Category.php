<?php

namespace App\Http\Livewire;

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\Rule;
use Livewire\Component;
use Livewire\WithPagination;

class Category extends Component
{
    use WithPagination;

    public $name;
    public $category_id = null;

    protected $paginationTheme = 'bootstrap';

    protected function rules()
    {
        if(is_null($this->category_id)){
            return [
                'name' => ['required', 'unique:categories,name'],
            ];
        }
        return [
            'name' => ['required', Rule::unique('categories')->ignore($this->category_id)],
        ];
    }

    protected function validationAttributes()
    {
        return [
            'name' => __('Category')
        ];
    }

    public function add()
    {
        $this->validate();
        DB::transaction(function(){
            Auth::user()->categories()->create([
                'name' => $this->name,
            ]);
        });
        $this->category_id = null;
        $this->name = null;
    }

    public function edit($id)
    {
        $category = Auth::user()->categories()->where('id', $id)->first();
        $this->name = $category->name;
        $this->category_id = $id;
    }

    public function update()
    {
        $this->validate();
        DB::transaction(function(){
            Auth::user()->categories()->where('id', $this->category_id)->update([
                'name' => $this->name,
            ]);             
        });
        $this->category_id = null;
        $this->name = null;
    }

    public function cancel()
    {
        $this->category_id = null;
        $this->name = null;
    }

    public function destroy($id)
    {
        DB::transaction(function() use($id){
            $category = Auth::user()->categories()->where('id', $id)->first();
            $category->delete();
        });
    }

    public function render()
    {
        $categories = Auth::user()->categories()->paginate(10);

        return view('livewire.category', ['categories' => $categories])
            ->extends('layouts.app');
    }
}
