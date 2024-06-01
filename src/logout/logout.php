<?php
session_start();
session_unset();
session_destroy();
header("Location: ../user-options/user-options.html");
exit();
