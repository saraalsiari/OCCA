<html>
<body>
Hello there!
<br>
This is your code: <br> <?php echo $_POST["code"]; ?><br>
<?$fp = fopen($_FILES['uploadFile']['tmp_name'], 'rb');
    while ( ($line = fgets($fp)) !== false)
    {
      echo "$line<br>";
    }
  ?>
  
</body>
</html>
