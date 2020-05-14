## finder 问题
            
  $finder->files()->in($this->dir_in)->name($fileName)->depth('== 0');
  

没有深度导致重复读取。

## flushMessage （一次性消息）

// set flash messages
$session->getFlashBag()->add('notice', 'Profile updated');

// retrieve messages
foreach ($session->getFlashBag()->get('notice', []) as $message) {
    echo '<div class="flash-notice">'.$message.'</div>';
}

https://symfony.com/doc/current/components/http_foundation/sessions.html#flash-messages
http://www.symfonychina.com/doc/current/session/avoid_session_start.html