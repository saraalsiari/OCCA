<!DOCTYPE html>
<html>

 <head>
        <meta charset="utf-8">
        <title>Software Engineering Project</title>
        <link rel="stylesheet" href="style.css">
        <link rel="stylesheet" href="https://fonts.googleapis.com/icon?family=Material+Icons">
        <link rel="stylesheet" href="https://www.w3schools.com/w3css/4/w3.css">
		<script src="http://ajax.googleapis.com/ajax/libs/jquery/1.11.2/jquery.min.js"></script>

</head>

<body>
        <!-- login start -->
<p align="right">
      <button onclick="document.getElementById('id01').style.display='block'" style="width:auto;">Login</button>
</p>
    
<div id="id01" class="modal">
  <form class="modal-content animate" action="/action_page.php" method="post">
    <div class="container">
      <label for="uname"><b>Username</b></label>
      <input type="text" placeholder="Enter Username" name="uname" required>

      <label for="psw"><b>Password</b></label>
      <input type="password" placeholder="Enter Password" name="psw" required>

      <button type="submit">Login</button>
      <label>
        <input type="checkbox" checked="checked" name="remember"> Remember me
      </label>
    </div>

    <div class="container" style="background-color:#f1f1f1">
        <span class="psw">Forgot <a href="#">password?</a></span>
        <br>
      <button type="button" onclick="document.getElementById('id01').style.display='none'" class="cancelbtn">Cancel</button>
      
    </div>
  </form>
</div>

<script>
// Get the modal
var modal = document.getElementById('id01');

// When the user clicks anywhere outside of the modal, close it
window.onclick = function(event) {
    if (event.target == modal) {
        modal.style.display = "none";
    }
}
</script>
<!-- login end-->
        <h1></h1>
        <img src="image.jpg" alt="" width="100%">
        <h1>Check your code here</h1>
        
        <div class="center">
            <br>
            <form  method="post">
                <div class="container">
                    <textarea id="code" name="code" placeholder="Enter your code here..." rows="20" cols="50"></textarea>
					<textarea id="line"></textarea>
					
					 <input class="button_clear" type ="submit" id="button1" name="button1" value="button1">
					
					
                </div>
				
				
				
			<?php
			
  function linesNum(){
	  parser();
			$arr = explode("\r\n", trim($_POST['code']));
			
			//echo "<script type='text/javascript'>alert('$arr[1]');</script>";
			
			
			for ($i = 0; $i < count($arr); $i++) 
			{
			$lines = $arr[$i];
			
			
			echo "<script> type='text/javascript'> 
				alert('$lines');
				document.getElementById('line').innerHTML += '$lines'; 
				</script>";
				
			//echo "<script type='text/javascript'> 
		    //document.getElementById('line').innerHTML=document.getElementById('line').innerHTML +$lines[$i];
			//</script>";
			}//end for loop
			//echo '<script>alert("after loop")</script>';
			return $lines;
			}//end function
 

			///////////////////////////////////////////////////////////////////////////////////////////////////////////
			///////////////////////////////Converting java code///////////////////////////////////////////////////////
			function parser(){
			//defining arrays for keywords 
			$keywords = array("scanf","printf","main","static");
			$datatypes = array("int","float","double","char");	
			
			//initializing arrays
			$operators = array();	
			$operands = array();	
			$variables = array();
			
			//initilizing counts
			$operatorCount = 0; 
			$operandCount = 0;
			
			//initilizing flag
			$skipFlag = false;
			
			//retrieiving code lines into array $arr each line at index i 
			$arr = explode("\r\n", trim($_POST['code']));
			
			//for loop
			for ($i = 0; $i < count($arr); $i++) 
			{
			$line_i = $arr[$i];
			
			
			foreach ($keywords as $keyword)
				{
					if( startsWith( $line_i , $keyword))
					{
						$line_i = substr($line_i,strlen($keyword));///I am not sure --> what should sbstr() return
						echo "The keyword is: " . $keyword ."\r\n";
						echo "start sbudtring: " . strlen($keyword) ."\r\n";
						echo "String after extract operator" . $line_i ."\r\n";
						array_push($operators, $keyword);
						$operatorCount++;
						
					}
				}
				
				foreach( $datatypes as $datatype )
				{
					if(startsWith($line_i ,$datatype))
					{
						array_push($operators, $datatype);
						$operatorCount++;
						$index = stripos($line_i, $datatype);
						$line_i= substr($line_i,($index+strlen($datatype)),(strlen($line_i)-($index+strlen($datatype))));  // -1 to ignore the semicolon
						echo "String after extract datatype" . $line_i ."\r\n";
						echo "start sbudtring: " . ($index+strlen($datatype)) ."\r\n";
						echo "end sbudtring: " . ((strlen($line_i)-($index+strlen($datatype)))) ."\r\n";
						$vars = explode(",", $line_i);
						foreach( $vars as $v )
						{
							$v =trim($v);
							array_push($variables, $v);
						}
					}
				}
				$variables = reorderVariables($variables);  // very important !
				$skipFlag = false;
			
			
			
			
			}//end of for loop
			echo "operators count= " . $operatorCount ."\r\n";
			echo "variables count= " . count($variables) ."\r\n";
			echo "variables array= " . print_r($variables) ."\r\n";
			echo "operators array= " . print_r($operators) ."\r\n";
			
			
			}
			
			//----------------------------methods for parser
			//METHOD (startsWith) -----------
			function startsWith( $haystack, $needle ) 
			{
				$length = strlen( $needle );
				return substr( $haystack, 0, $length ) === $needle;
			}
			//-----------------------------------------------------
			//METHOD (endsWith) -----------
			function endsWith( $haystack, $needle ) 
			{
				$length = strlen( $needle );
				if( !$length ) 
				{
					return true;
				}
				return substr( $haystack, -$length ) === $needle;
			}
			//-----------------------------------------------------
			function reorderVariables($variables)
			{
				$lengths = array();
				//filling lengths array
				for( $i=0;$i<count($variables);$i++)
				{
					$lengths[$i] = strlen($variables[$i]);
				}//end loop for lengths
				
				for($i=0;$i<count($lengths);$i++)
				{
					for($j=$i+1;$j<count($lengths);$j++)
					{
						if($lengths[$i] < $lengths[$j])
						{
							$temp = $lengths[$i];
							$lengths[$i] = $lengths[$j];
							$lengths[$j] = $temp;

							$tmp_var = $variables[$i];
							$variables[$i]=$variables[$j];
							$variables[$j]=$tmp_var;
						}
					}
				}
			return $variables;
			}//end function (reorderVariables)
			
			///////////////////////////////////////////////////////////////////////////////////////////////////////////
			
			
 
						
			
				
			
			//Button
			if(isset($_POST['button1'])){
			linesNum();	
			}
			
			

			?>	
	
                <br><br>
        
  <!-- هذي ليش مقفلة هنا مو المفروض بعد تاق الفورم -->      
               </div>
               <br>
  
  <!-- The `multiple` attribute lets users select multiple files. -->
  
              <label class="file">
                  <input type="file"  id="file-selector" accept=".txt" aria-label="File browser example">
                  <span class="file-custom"></span>
             </label><br><br>
  
             <script>
                 const fileSelector = document.getElementById('file-selector');
                 fileSelector.addEventListener('change', (event) => {
                     const fileList = event.target.files;
                     console.log(fileList);
                 });
             </script>
  
             <script>
                 let input = document.querySelector('input[type="file"]');
                 let textarea = document.querySelector('textarea');

                 input.addEventListener('change', () => 
                 {
                     let files = input.files;
                     if(files.length == 0) return;
                     const file = files[0];
                     let reader = new FileReader();
                     reader.onload = (e) =>
                     {
                         const file = e.target.result;
                         const lines = file.split(/\r\n|\n/);
                         textarea.value = lines.join('\n');
                     };
                    reader.onerror = (e) => alert(e.target.error.name);
                    reader.readAsText(file); 
                 });
            </script>

            <input class="button" type="submit" value="Submit">
            <input class="button" type="button" value="Show Results" onclick="showDiv()">
            <input class="button_clear" type="reset" value="Clear!" onclick="hideDiv()">
            <br><br>
            <input class="button" type="button" value="Read the file" onclick="readFile(document.getElementById("file-selector").value)">
     </form>
     <br>
     <br>

<div id="results"  style="display:none;" class="answer_list" > The results:
  
     <div class="output row">
       <div>Characters: <span id="characterCount">0</span></div>
	   
       <div>Words: <span id="wordCount">0</span></div>
     </div>
  
     <div class="output row">
      <div>Sentences: <span id="sentenceCount">0</span></div>
      <div>Paragraphs: <span id="paragraphCount">0</span></div>
    </div>
  
    <div class="output row">
      <div>Reading Time: <span id="readingTime">0</span></div>
      <div id="readability">Show readability score.</div>
    </div>
  
    <div class="keywords">
      Top keywords:
      <ul id="topKeywords">
      </ul>
    </div>
  
</div>
  
  
  <script>
      function showDiv() 
      {
          var content1 = document.getElementById("code").value;
          var content2 = document.getElementById("file-selector").value;
          if((content1.length>1) || (content2 !=""))
             {
              document.getElementById('results').style.display = "block";
            
             }
         else
            {
            window.alert ("There is no code to analyze! Please Upload the code!");
            }
      }
    
    
    
     function hideDiv() 
      {
        document.getElementById('results').style.display = "none";
      }
    
    input.addEventListener('keyup', function() {

  // word counter logic

  // sentence count logic

  // reading time calculation

  // keyword finding logic

    });
    
    
    function readFile(file) {
        const reader = new FileReader();
        reader.addEventListener('load', (event) => {
             const result = event.target.result;
    // Do something with result
        });

       reader.addEventListener('progress', (event) => {
           if (event.loaded && event.total) 
             {
               const percent = (event.loaded / event.total) * 100;
               console.log(`Progress: ${Math.round(percent)}`);
             }
       });
       reader.readAsDataURL(file);
     }
  
  </script>  
 
</body>
  
<br>
<br>
<br>
<br>
<br>
<br>
  
  <footer>
     by Bdoor, Mona, Sara A, Sara M, Sumayyah
  </footer>

</html>
