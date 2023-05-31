<?php

namespace App\Http\Livewire;

use Livewire\Component;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Redis;

class CategorySelect extends Component
{
    public $upload_id;
    public $photo_id;

    public $name;
    public $checks=[];

    protected $listeners = [
        'modalOpenNew' => 'openNew',
        'modalOpen' => 'open',
    ];

    protected $rules = [
        'name' => ['required', 'unique:categories,name'],
    ];

    protected function validationAttributes()
    {
        return [
            'name' => __('Category')
        ];
    }


    public function add()
    {
        $this->validate();

        $query = Auth::user()->categories()->where('name', $this->name);
        if(is_null($query->first())){
            DB::transaction(function(){
                $category = Auth::user()->categories()->create([
                    'name' => $this->name,
                ]);
                $this->name = null;
                $this->checks[$category->id] = true;
            });
            $this->emitUp('refreshComponent');
        }
    }

    public function openNew($id)
    {
        $this->upload_id = $id;
        $this->checks = [];
    }

    public function open($id)
    {
        $this->checks = [];
        $photo = Auth::user()->photos()->where('id', $id)->first();
        if($photo){
            foreach($photo->categories()->cursor() as $category){
                $this->checks[$category->id] = true;
            }
        }
        $this->photo_id = $id;
    }

    private function sync($id, $values)
    {
        $photo = Auth::user()->photos()->where('id', $id)->first();
        if($photo){
            $photo->categories()->sync($values);
        }
    }

    public function submit()
    {
        $checks = [];
        foreach($this->checks as $key => $value){
            if($value){
                array_push($checks, (int)$key);
            }
        }
        if($this->photo_id){
            $this->sync($this->photo_id, $checks);
        }
        $upload = 'upload-'.$this->upload_id;
        if(Redis::exists($upload)){
            foreach(Redis::lRange($upload, 0, -1) as $photo_id){
                $this->sync($photo_id, $checks);
            }
        }
        $this->checks = [];
        $this->close();
    }

    public function close()
    {
        $upload = 'upload-'.$this->upload_id;
        if(Redis::exists($upload)){
            Redis::del($upload);
        }
        $this->resetErrorBag();
        $this->emit('modalCloseed');
    }

    public function render()
    {
        $query = Auth::user()->categories();
        $categories = $query->get();
        return view('livewire.category-select', ['categories' => $categories]);
    }
}
