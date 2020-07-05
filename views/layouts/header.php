<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="_url" id="url" content="<?php echo constant('URL') ?>">
    <title><?php echo $this->title; ?></title>
    <link rel="stylesheet" href="<?php echo constant('URL') ?>public/css/bootstrap.min.css">
    <link rel="stylesheet" href="<?php echo constant('URL') ?>public/css/toastr.min.css">
    <link rel="stylesheet" href="https://cdn.datatables.net/1.10.21/css/dataTables.bootstrap4.min.css">
    <link rel="stylesheet" href="https://cdn.datatables.net/responsive/2.2.5/css/responsive.bootstrap4.min.css">
    <link href="https://fonts.googleapis.com/css2?family=Nunito:ital,wght@0,300;0,400;1,300;1,400&display=swap" rel="stylesheet">
    <?php
    foreach ($this->styles as $style) { ?>
        <link rel="stylesheet" href="<?php echo constant('URL') ?>public/<?php echo $style; ?>">
    <?php } ?>
    <style>
        * {
            font-family: 'Nunito', sans-serif;
        }

        td.buttons {
            width: 120px;
        }

        @media (max-width: 320px) {
            td.buttons {
                width: 120px !important;
            }

            h4 {
                font-size: 20px !important;
            }

            h5 {
                font-size: 18px !important;
            }

            li.paginate_button.previous {
                display: inline;
            }

            li.paginate_button.next {
                display: inline;
            }

            li.paginate_button {
                display: none;
            }
        }

        @media (max-width: 768px) {
            td.buttons {
                width: 120px;
            }

            h5 {
                font-size: 24px;
            }
        }
    </style>
</head>

<body style="background: #f8fafc">