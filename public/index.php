<?php declare(strict_types=1);
        function render(string $templatePath, array $params): string
        {
            extract($params);
            ob_start();
            ob_implicit_flush(false);

            require $templatePath;

            return ob_get_clean();
        }

        $renderAbout = render('about.php', ['title' => 'About']);
        $renderMain = render('main.php', ['title' => 'Main']);
        $renderNotes = render('notes.php', ['title' => 'Notes']);

        if ($_SERVER['REQUEST_URI'] == '/About') {
            echo $renderAbout;
        } elseif ($_SERVER['REQUEST_URI'] == '/Notes') {
            echo $renderNotes;
        } else {
            echo $renderMain;
        }
    ?>