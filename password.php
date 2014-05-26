<?php
FUNCTION createSalt()
				{
				$text = md5(uniqid(rand(), TRUE));
				RETURN substr($text, 0, 3);
				}

				$salt = createSalt();
				$password = hash('sha256', $salt . $hash);

				echo $password;
?>