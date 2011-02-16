# Toco - Micro framework for PHP 5 #

## General ##

Toco is a lightweight request dispatcher / micro framework for PHP 5. Inspired by Django
<http://www.djangoproject.com/> and verbier <http://github.com/Hanse/verbier>.
Uses Twig <http://www.twig-project.org/> as the default template engine.

## Author ##

Amitay Horwitz <amitayh@gmail.com>

## License ##

The MIT License - <http://www.opensource.org/licenses/mit-license.php>

## How to write an app using Toco? ##

Writing an application with Toco is as easy as defining a route (URL pattern) and view function.
The view function will receive the Toco_Request object as the first argument, and an array of matching
patterns from the URL as the second argument. It must return an instance of Toco_Response (or a
subclass). Let's see how this works:

*config.php*

    define('DEBUG', false);
    define('APPLICATION_PATH', realpath(dirname(__file__) . '/..'));
    define('TEMPLATES_PATH', APPLICATION_PATH . '/templates');
    define('CACHE_PATH', APPLICATION_PATH . '/cache');

*index.php*

    // Setup Toco
    $toco = new Toco::getInstance();

    // Define URLs
    $toco->route('^$', 'index');

    // Define view function
    function index(Toco_Request $request) {
        return new Toco_Response('Hello World');
    }

    // Dispatch the request
    $toco->run();

### URLs ###

You will need to define your app's URLs by mapping them to regular expression patterns.
The URL patterns will be mapped to a view function that will be responsible for the business logic
(if needed) and returning a response object.

You can capture patterns inside your URLs that will be passed to your view functions.
For example, let's say you have a blog. You want your article URL to look like this:

http://www.mysite.com/blog/view/123/

To map this URL you will do something like this:

    $toco->route('^blog/view/(?P<id>\d+)/$', 'blog-view');

Then, you can get the captured ID in your view function, like so:

    function blog-view(Toco_Request $request, $matches) {
        // Captured ID is now $matches['id']
        ...
    }

If you have several URLs that are related, it would be wise to use a recursive match. For example,
in your blog you have 3 URLs:

1. Blog index page - http://www.mysite.com/blog/
2. Blog category page - http://www.mysite.com/blog/category/123/
3. Blog article page - http://www.mysite.com/blog/view/123/

Instead of defining your URLs like so:

    $toco->route('^blog/$', 'blog-index');
    $toco->route('^blog/category/(?P<id>\d+)/$', 'blog-category');
    $toco->route('^blog/view/(?P<id>\d+)/$', 'blog-view');

You can do this:

    $blogUrls = array(
        array('^$', 'blog-index');
        array('^category/(?P<id>\d+)/$', 'blog-category');
        array('^view/(?P<id>\d+)/$', 'blog-view');
    );
    $toco->route('^blog/', $blogUrls);

Note: the first URL pattern that matches the request will be used, so pay attention to the order in
which the routes are set.

### View functions ###

Your view functions will handle the business logic. Let's take the previous example: your view function
will probably use the captured ID from the URL and look for it in a database. You can then return
a Toco_Response instance.

Note: if your view function returns something else, an exception will be risen.

If you want to return a 404 page (for example, if your article ID does not exist in the database) you
can throw a Toco_Exception_404 exception, like so:

    function blog-view(Toco_Request $request, $matches) {
        // Captured ID is now $matches['id']
        $blog = new BlogModel();
        $article = $blog->find($matches['id']);
        if (!$article) {
            // This will cause a 404 page to be returned
            throw new Toco_Exception_404();
        }
        return new Toco_Response('Blog - ' . $article->title);
    }

Also, you can also use the Toco_Response_Redirect class to redirect the request, like so:

    function blog-view(Toco_Request $request, $matches) {
        // Captured ID is now $matches['id']
        if (12 == $matches['id']) {
            return new Toco_Response_Redirect('http://www.path.to/redirect.html');
        }
        ...
    }

### Using the template system ###

Toco uses Twig as its default template engine. Twig is a flexible and fast templating language of which
you can find full documentation here: <http://www.twig-project.org/>.
This is how to return a response from a template:

*index.php*

    function index(Toco_Request $request) {
        $context = array(
            'name => 'Amitay Horwitz'
        );
        return Toco_Response::renderToResponse('index.html', $context);
    }

*index.html*

    <html>
        <head>
            <title>My Toco App</title>
        </head>
        <body>
            <h1>Hello World</h1>
            <p>Hi, my name is {{ name }}!</p>
        </body>
    </html>

There's a lot more you can benefit from using Twig (like template inheritance, plugins and more) but
check out the official website for full documentation.

### Middlewares ###

WRITE ME