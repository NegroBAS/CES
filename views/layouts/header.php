<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="_url" id="url" content="<?php echo constant('URL') ?>">
    <title><?php echo $this->title; ?></title>
    <link rel="stylesheet" href="<?php echo constant('URL') ?>public/css/bootstrap.min.css">
    <link rel="stylesheet" href="<?php echo constant('URL') ?>public/css/toastr.min.css">
    <link rel="stylesheet" href="<?php echo constant('URL') ?>public/css/editor.css">

    <link rel="stylesheet" href="https://cdn.datatables.net/1.10.21/css/dataTables.bootstrap4.min.css">
    <link rel="stylesheet" href="https://cdn.datatables.net/responsive/2.2.5/css/responsive.bootstrap4.min.css">
    <link href="https://fonts.googleapis.com/css2?family=Questrial&family=Source+Sans+Pro:ital,wght@0,300;1,300&display=swap" rel="stylesheet">
   <?php
    foreach ($this->styles as $style) { ?>
        <link rel="stylesheet" href="<?php echo constant('URL') ?>public/<?php echo $style; ?>">
    <?php } ?>
    <style>
        *{
            font-family: 'Questrial', sans-serif;
        }
    </style>
</head>

<body style="background: #f8fafc">