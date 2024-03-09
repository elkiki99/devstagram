<?php

namespace App\Livewire;

use Livewire\Component;
use App\Models\Comentario;
use Illuminate\Database\Eloquent\Collection as EloquentCollection;


class CommentPost extends Component
{
    public $post;
    public $comentario;
    public $user;

    public EloquentCollection $comentarios;

    public function mount($post){
        $this->post = $post;
        $this->user = auth()->user();
        $this->comentarios = $post->comentarios;
    }

    public function store()
    {
        $this->validate([
            "comentario" => "required|max:255"
        ]);

        // Almacenar
        $newComment = Comentario::create([
            "user_id" => auth()->user()->id,
            "post_id" => $this->post->id,
            "comentario" => $this->comentario
        ]);
         
        $this->comentarios->prepend($newComment);
        $this->reset('comentario');
    }

    public function render()
    {
        return view('livewire.comment-post');
    }
}
