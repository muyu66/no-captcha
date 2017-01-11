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
        $this->captcha->generate();
        $ctl = new Template();
        return $ctl->view('code');
    }
        
    public function getCodeValid()
    {
        $this->captcha->valid();
    }
        
    public function getCodeQuery()
    {
        $this->captcha->query();
    }
