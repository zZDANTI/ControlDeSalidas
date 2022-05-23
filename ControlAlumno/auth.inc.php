<?php
session_start();
if (!isset($_SESSION['user_id'])) {
    // Redirección a login
    exit();
}