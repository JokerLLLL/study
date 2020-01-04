# twig全局global变量
twig:
    # ...
    globals:
        ga_tracking: UA-xxxxx-x
        ga_tracking: '%ga_tracking%'
        user_management: '@app.user_management'

全局app变量：                
http://www.symfonychina.com/doc/current/templating/app_variable.html    
<p>Username: {{ app.user.username }}</p>
{% if app.debug %}
    <p>Request method: {{ app.request.method }}</p>
    <p>Application Environment: {{ app.environment }}</p>
{% endif %}
        
        
# 模板使用

使用命名空间路径，下面的工作是一样的：
{% extends "AppBundle::layout.html.twig" %}
{{ include('AppBundle:Foo:bar.html.twig') }}
{% extends "@App/layout.html.twig" %}
{{ include('@App/Foo/bar.html.twig') }}

# twig 命名空间

twig:
    # ...
    paths:
        "%kernel.root_dir%/../vendor/acme/foo-bar/templates": foo_bar
        
{{ include('@foo_bar/sidebar.twig', {"params":article}) }}


# 函数

path 渲染路由
{{ path('_welcome') }}

注册 css js static
{{ absolute_url(asset('images/logo.png')) }}

转义
{{params | raw }}
{{params | escape('js')}}


# 扩展twig

namespace Uco\OmsBundle\Twig;

use Twig\TwigFilter;

class ToolsExtension extends \Twig_Extension
{
    public function getTests()
    {
        return [
            new \Twig_SimpleTest('instanceof', [$this, 'instanceOf']),
        ];
    }
    
    //使用 {% if e is instanceof("\Exception") %};
    public function instanceOf($var, $instance)
    {
         $exceptionClass = $var->getClass();
         $reflexionClass = new \ReflectionClass($exceptionClass);
         $exceptionInstance = $reflexionClass->newInstanceWithoutConstructor();
         return $exceptionInstance instanceof $instance;
    }
        
    public function getFilters()
    {
        return [
            new TwigFilter('renderForm', [$this, 'renderForm']),
        ];
    }
    
     // {{ warehousingReceivedLines | renderForm() }}       
    public function renderForm($test)
    {
        var_dump($test);
    }
            
}