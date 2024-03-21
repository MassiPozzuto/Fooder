<?php
    function exception_error_handler($error_level, $error_message, $error_file, $error_line, $error_context)
    {
        require 'technical_error.php';
        die;
    }
    set_error_handler("exception_error_handler");
?>