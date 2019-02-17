<?php

namespace Blog\Model;

/**
 *
 * @author emi
 */
interface PostRepositoryInterface {
    /**
     * Devuelve un conjunto de todas las publicaciones 
     * de blog que podamos repetir.
     * Cada entrada debe ser una instancia de publicación.
     * @return Post[]
     */
    function findAllPosts();
    
    /**
     * Devuelve una sola entrada de blog.
     * @param int $ id Identificador de la 
     * publicación a devolver.
     * @return Post
     */
    function findPost(int $id);
}
