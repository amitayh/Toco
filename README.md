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
    $toco->route(new Toco_Route('/'), 'index');

    // Define view function
    function index(Toco_Request $request) {
        return new Toco_Response('Hello World');
    }

    // Dispatch the request
    $toco->run();

### URLs ###

You will need to define your app's URLs by mapping them to patterns.
The URL patterns will be mapped to a view function that will be responsible for the business logic
(if needed) and returning a response object.

You can capture patterns inside your URLs that will be passed to your view functions.
For example, let's say you have a blog. You want your article URL to look like this:

http://www.mysite.com/blog/2011/03/my-blog-entry/

To map this URL you will do something like this:

    $toco->route(new Toco_Route('/blog/:year/:month/:slug'), 'blog-view');

Then, you can get the captured patterns in your view function, like so:

    function blog-view(Toco_Request $request, $matches) {
        // Captured slug is now $matches['slug']
        ...
    }

Note: the first URL pattern that matches the request will be used, so pay attention to the order in
which the routes are set.

### View functions ###

Your view functions will handle the business logic. Let's take the previous example: your view function
will probably use the captured slug from the URL and look for it in a database. You can then return
a Toco_Response instance.

Note: if your view function returns something else, an exception will be risen.

If you want to return a 404 page (for example, if your article slug does not exist in the database) you
can throw a Toco_Exception_404 exception, like so:

    function blog-view(Toco_Request $request, $matches) {
        // Captured ID is now $matches['slug']
        $blog = new BlogModel();
        $article = $blog->find($matches['slug']);
        if (!$article) {
            // This will cause a 404 page to be returned
            throw new Toco_Exception_404();
        }
        return new Toco_Response('Blog - ' . $article->title);
    }

Also, you can also use the Toco_Response_Redirect class to redirect the request, like so:

    function blog-view(Toco_Request $request, $matches) {
        // Captured ID is now $matches['slug']
        if ('hello-world' == $matches['slug']) {
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