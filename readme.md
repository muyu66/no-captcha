## Muyu No-Captcha

### Building...

### How to render page ?
    public function getCode()
    {
        $ctl = new Template();
        return $ctl->view('code', [
            'generate' => 'http://127.0.0.1/auth/code-generate',
            'valid' => 'http://127.0.0.1/auth/code-valid',
            'query' => 'http://127.0.0.1/auth/code-query',
            'name' => 'Muyu',
            'sign' => 'Inc',
            'message' => '吾，非机器人也',
        ]);
    }
    
### How to use ?

    private $captcha;
        
    public function __construct()
    {
        $this->captcha = new Captcha();
        
        /**
         * you can choose
         * useFile | useRedis | useMemcache
         * param is driver connection instance
         */
                  
        $this->captcha->useMemcache($memcached);
    }
        
    public function postLogin()
    {
        if(! $this->getCodeQuery())
        {
            throw new Exception('you are robot');
        }
    }
        
    public function getCodeGenerate()
    {
        return $this->captcha->generate();
    }
        
    public function getCodeValid()
    {
        return $this->captcha->valid();
    }
        
    private function getCodeQuery()
    {
        return $this->captcha->query();
    }