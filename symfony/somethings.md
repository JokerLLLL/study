## finder 问题
            
  $finder->files()->in($this->dir_in)->name($fileName)->depth('== 0');
  

没有深度导致重复读取。