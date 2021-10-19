/* 
#################################################
I wrote this class to connect to Emory University LDAP authentication
This class authenticated via LDAP and was used in conjunction with 
An extension class that authenticated per internal application,
################################################
*/
class LDAP{
	//posted username and password
	private $username;
	private $password;
	
	//boolean set for session setting
	public $passed;
	
	// Setup host
	private $ldap_host = LDAP_HOST;
	private $ldap_search_base = LDAP_SEARCH_BASE;
	private $ldap_service_base="dc=eu,dc=xxx=edu";
	public $ldap_conn;
	public $r;
	
	//this is the var for the bind
	public $searchBind;
	
	//this is the var for the search bind
	public $user_dn;
	public $search_id;
	public $user_info;
	private $srvc_id = LDAP_USER_NAME;

	//your service account name
	private $srvc_pass = LDAP_PASSWORD;

	//password associated with your account
	public $srvc_dn;
	public $user_filter;
	public $user_attr=array("uid","title","cn","mail","organizationalStatus","ou","telephoneNumber","serialNumber");
 
	// dn is optional
	public $user_status;
	public $user_info_array = array();
	public $supervisors_info = array();
	
	public function __construct(){
		
		//concatenate the service dn
		$this->srvc_dn = "uid=$this->srvc_id,ou=services,$this->ldap_service_base"; //connect to LDAP
		$this->ConnectLDAP();
		
		//return the value
		return $this->srvc_dn; 
	}
	
	public function ConnectLDAP(){
		
		//connect to the LDAP server
		$this->ldap_conn=ldap_connect($this->ldap_host,636);
		//if the connection is a go, proceed, WARNING, this may return true regardless 
		if ($this->ldap_conn) {
			//bind to the server, using the credentials
			$this->r=ldap_bind($this->ldap_conn, $this->srvc_dn, $this->srvc_pass); 
		}
		//return the value of the bind
		return $this->r;
	}
	
	public function SetSearchLDAPRecords(){
		
		$this->user_info_array[] = $this->user_info[0]["uid"][0];
		$this->user_info_array[] = $this->user_info[0]["mail"][0];
		$this->user_info_array[] = $this->user_info[0]["cn"][0];
		$this->user_info_array[] = $this->user_info[0]["ou"][0];
		
		return $this->user_info_array; 
	}
}