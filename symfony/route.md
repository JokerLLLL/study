##路由

routing.yml
```

# 支持标注
abc_joker:
    resource: "@abcJokerBundle/Controller/"
    type: annotation

UcoOmsBundle_BusyBee:
    resource: "@UcoOmsBundle/Controller/Api/BusyBeeController.php"
    type: annotation

# 支持yml配置
bundleJokerRout:
    resource: "@abcJokerBundle/Resources/config/routing.yml"
    prefix:   /




-- annotation 路由

/**
 * @Route("pre","Pre_")
 */
class ArticleController extends Controller
{
    /**
     * @Route(
     *     "/articles/{_locale}/{year}/{slug}.{_format}",
     *     defaults={"_format": "html"},
     *     requirements={
     *         "_locale": "en|fr",
     *         "_format": "html|rss",
     *         "year": "\d+"
     *     }
     * )
     */
    public function showAction($_locale, $year, $slug)
    {
    }
    
    /**
     * @Route("/login")
     * @Template("@ucoTms/Practice/login.html.twig")
     * @Method("PUT")
     */
    public function testAction()
    {
        return $this->render('@ucoTms/Default/index.html.twig');
        return $this->render('abcOmsBundle:Default:index.html.twig'); //版本错误！！？
    }
}


## 路由跳转

return $this->redirectToRoute('homepage');
return $this->redirectToRoute('homepage', array(), 301);
return $this->redirect('http://symfony.com/doc');




