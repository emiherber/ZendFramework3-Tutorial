<?php

namespace Blog\Model;

/**
 *
 * @author emi
 */
interface PostCommandInterface {
    /**
     * Persiste un nuevo post en el sistema.
     * 
     * @param \Blog\Model\Post $post 
     * El post para insertar; Puede o no 
     * tener un identificador.
     * @return \Blog\Model\Post Publicar el mensaje 
     * insertado, con identificador.
     */
    function insertPost(Post $post);
    /**
     * Actualiza un post existente en el sistema
     * 
     * @param \Blog\Model\Post $post 
     * Publica para actualizar; Debe tener un 
     * identificador.
     * @return \Blog\Model\Post Actualizado
     */
    function updatePost(Post $post);
    
    /**
     * Elimina un post del sistema
     * 
     * @param \Blog\Model\Post $post a eliminar.
     * @return bool
     */
    function deletePost(Post $post);
}
