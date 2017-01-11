## Muyu No-Captcha

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
        
    public function getCode()
    {
        $ctl = new Template();
        return $ctl->view('code', [
            'generate' => 'http://127.0.0.1/auth/code-generate',
            'valid' => 'http://127.0.0.1/auth/code-valid',
            'query' => 'http://127.0.0.1/auth/code-query',
        ]);
    }
        
    public function getCodeGenerate()
    {
        return $this->captcha->generate();
    }
        
    public function getCodeValid()
    {
        return $this->captcha->valid();
    }
        
    public function getCodeQuery()
    {
        return $this->captcha->query();
    }