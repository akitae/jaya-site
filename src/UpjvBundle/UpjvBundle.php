<?php

namespace UpjvBundle;

use Symfony\Component\HttpKernel\Bundle\Bundle;

class UpjvBundle extends Bundle
{

    public function getParent () {
        return 'FOSUserBundle';
    }

}
