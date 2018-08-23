<?php
/**
 * Token, Genera codigo unico
 * 
 * La Calsse Token es la encargada de generar codigos unicos basados en numeros, letras, y caracteres especiales
 * @author David Fernandez <fernandezdg@gmail.com>
 * @version 1.01 (10/05/2010 - 02/03/2011)
 * @package Framework
 */
/**
 * Token class,
 * @package Framework
 * @subpackage framework
 */
class Token {	
	/**
	 * Configuration private variable values, 
	 * 
	 * Configuration values
	 * @access private
	 * @var string
	 */
	private $_strLower = "";
	/**
     * Configuration values
	 * @access private
	 * @var string
	 */
	private $_strUpper = "";
	/**
     * Configuration values
	 * @access private
	 * @var number
	 */
	private $_strNumbers = "";
	/**
     * Configuration values
	 * @access private
     * @var string
     */
	private $_strSpecial = "";
	/**
     * Configuration values
	 * @access private
     * @var number
     */
	private $_minLength = 0;
	/**
     * Configuration values
	 * @access private
     * @var number
     */
	private $_maxLength = 0;
	/**
     * Configuration values
	 * @access private
     * @var number
     */
	private $_length = 0;
	/**
     * Configuration values
	 * @access private
     * @return string
     */
	private $_aplicaStr = "";
	/**
     * Configuration values
	 * @access private
     * @var number
     */
	private $_strKey = "";
	
	/**
     * Set this object to configurate the elements to use
     *
     * @param  string|number  $strLower, $strUpper, $strNumbers, $strSpecial, $minLength, $maxLength
     * @return string old string
     */
    public function setChars($strLower = true, $strUpper = true, $strNumbers = true, $strSpecial = false)
    {
		$this->_strLower 	= $strLower;
		$this->_strUpper 	= $strUpper;
		$this->_strNumbers 	= $strNumbers;
		$this->_strSpecial 	= $strSpecial;
	}
	
	/**
     * Set this object to espesific the maximus and minimus of return the final string
     *
     * @param  number  $minLength, $maxLength
     * @return string string
     */
    public function setLength($minLength = 10, $maxLength = 10)
    {
		$this->_minLength 	= $minLength;
		$this->_maxLength 	= $maxLength;
	}
	
	/**
     * Returns this object's one new Token string
     * this generate a new string, implements the parameters previwsly configurate.
     *
     * @return  integer|string  timestamp
     */
    public function getToken()
    {
		$this->_strKey='';
    	$this->_aplicaStr = ($this->_strLower == true) 		? $this->_aplicaStr .= "abcdefghijklmnopqrstuvwxyz" : "";
		$this->_aplicaStr = ($this->_strUpper) 		? $this->_aplicaStr .= "ABCDEFGHIJKLMNOPQRSTUVWXYZ" : $this->_aplicaStr;
		$this->_aplicaStr = ($this->_strNumbers) 	? $this->_aplicaStr .= "0123456789" : $this->_aplicaStr;
		$this->_aplicaStr = ($this->_strSpecial) 	? $this->_aplicaStr .= "~@#$%^*()_+-={}|][" : $this->_aplicaStr;
		
		if ($this->_minLength > $this->_maxLength) 
		{
			$this->_length = mt_rand($this->_maxLength, $this->_minLength);
		}
		else 
		{
			$this->_length = mt_rand($this->_minLength, $this->_maxLength);
		}
		
		for ($i=0; $i<$this->_length; $i++)
		{
			$this->_strKey .= $this->_aplicaStr[(mt_rand(0,(strlen($this->_aplicaStr)-1)))];
		}
		return (string) $this->_strKey;
	}
	/**
     * Destructor sets up
	 * @see __destruct()
     */
	public function __destruct()
	{
		unset($this);
	}
}
?>