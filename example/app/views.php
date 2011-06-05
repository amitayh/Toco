<?php

// Homepage view
function index(Toco_Request $request, $params) {
    return Toco_Response::renderToResponse('index.html', array('menu' => 'home'));
}

// Forms
class ContactForm extends Toco_Form
{

    public function init() {
        $this->name = 'contact';


        $name = new Toco_Form_Field_Char('name');

        $email = new Toco_Form_Field_Email('email', false);

        $subject = new Toco_Form_Field_Char('subject');

        $message = new Toco_Form_Field_Char('message');
        $message->setWidget(new Toco_Form_Widget_Textarea());

        $this->addFields($name, $email, $subject, $message);
    }

}

function form(Toco_Request $request, $params) {
    
    if ($request->method == 'POST') {
        $form = new ContactForm($request->POST);
        if ($form->isValid()) {

            var_dump($form->getCleanedData('subject'));
            die;
            
        }
    } else {
        $form = new ContactForm();
    }

    $context = array(
        'form' => $form
    );

    return Toco_Response::renderToResponse('form.html', $context);
}

// Blog view functions. A simple example - in real world will probably use an ORM
function blogIndex(Toco_Request $request, $params) {
    return Toco_Response::renderToResponse('blog/index.html', $params);
}
function blogArchiveYear(Toco_Request $request, $params) {
    return Toco_Response::renderToResponse('blog/year.html', $params);
}
function blogArchiveMonth(Toco_Request $request, $params) {
    $time = mktime(0, 0, 0, $params['month'], 1, $params['year']);
    return Toco_Response::renderToResponse('blog/month.html', array('month' => date('M Y', $time)));
}
function blogArticle(Toco_Request $request, $params) {
    $title = ucwords(str_replace('-', ' ', $params['slug']));
    return Toco_Response::renderToResponse('blog/article.html', array('title' => $title));
}


// Default view
function defaultView(Toco_Request $request, $params) {
    $controllerName = strtolower($params['controller']);
    $controllerClass = ucfirst($controllerName) . 'Controller';
    if (!class_exists($controllerClass)) {
        throw new Toco_Exception_404('No route matches requested path: ' . $request->path);
    }
    $controller = new $controllerClass($request, $params);
    return $controller->renderToResponse(strtolower($params['action']));
}