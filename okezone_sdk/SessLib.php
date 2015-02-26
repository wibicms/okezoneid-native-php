<?php
/* author         : Adi Sukma Wibawa
   email          : wibi.cms@gmail.com
   date_created   : 25/02/2015
   revised        : 
*/
class SessLib
{
    public function __construct()
    {
        if(session_id() == '') {
            session_start();
        }
    }

    public function get_session_id(){
        return session_id();
    }

    public function set( $keys=array())
    {
        foreach ($keys as $key => $value) {
            $_SESSION[$key] = $value;
        }
        
    }

    public function get( $key )
    {
        return isset( $_SESSION[$key] ) ? $_SESSION[$key] : null;
    }

    public function get_all(){
        return $_SESSION;
    }

    public function regenerateId( $delOld = false )
    {
        session_regenerate_id( $delOld );
    }

    public function delete( $key )
    {
        unset( $_SESSION[$key] );
    }

    public function destroy()
    {
        session_destroy();
    }
}