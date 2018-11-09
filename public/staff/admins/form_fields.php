<?php
// prevents this code from being loaded directly in the browser
// or without first setting the necessary object
if(!isset($admin)) {
  redirect_to(url_for('/staff/admins/index.php'));
}
?>

<dl>
  <dt>First name</dt>
  <dd><input type="text" name="admin[first_name]" value="<?php echo h($admin->first_name); ?>" /></dd>
</dl>

<dl>
  <dt>Last name</dt>
  <dd><input type="text" name="admin[last_name]" value="<?php echo h($admin->last_name); ?>" /></dd>
</dl>

<dl>
  <dt>Email</dt>
  <dd><input type="text" name="admin[email]" value="<?php echo h($admin->email); ?>" /></dd>
</dl>

<dl>
  <dt>Username</dt>
  <dd><input type="text" name="admin[username]" value="<?php echo h($admin->username); ?>" /></dd>
</dl>

<dl>
  <dt>Password</dt>
  <dd><input type="password" name="admin[password]" value="" /></dd>
</dl>

<dl>
  <dt>Confirm Password</dt>
  <dd><input type="password" name="admin[confirm_password]" value="" /></dd>
</dl>
