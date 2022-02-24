<?php

namespace RadFic\Gastropod\GastropodAuth;

/**
 * Represent a Login Credential that will be used to authenticate users in Gastropod.
 * 
 * Gastropod will call Illuminate\Support\Facades\Auth::attempt($credentials) to login your user.
 * The content of the $credentials array will be determined by what you specify in
 * `config/config.gastropod.php`. It will accept an array of GastropodLoginCredential objects.s
 */
class GastropodLoginCredential{

	
	/**
	 * INPUT_REQUEST
	 * 
	 * The specified credential will be pulled from the body of the request.
	 *
	 * @var int
	 */
	const INPUT_REQUEST = 10;


	/**
	 * The type of the credential. It determines from where the value has to be pulled.
	 *
	 * @var int
	 */
	public $type;
	/**
	 * The key to use to pull the credential value. 
	 * For example the name of the parameter to look for in the request body.
	 *
	 * @var string
	 */
	public $key;

	/**
	 * Constructor 
	 *
	 * @param int $type
	 * @param string $key
	 * 
	 */
	public function __construct($type,$key){
        $this->type = $type;
        $this->key = $key;
	}
}
