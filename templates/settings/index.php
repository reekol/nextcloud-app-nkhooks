<?php

use \OCP\Util;

?>
<style>
#app-settings-content{
  max-height:700px !important
}
#app-settings-content input{
  width:280px !important
}
</style>
<div id="app-settings">
	<div id="app-settings-header">
		<button class="settings-button"
				data-apps-slide-toggle="#app-settings-content"
		>Add/Delete hooks.</button>
	</div>
	<div id="app-settings-content" class="opened" style="display:block">
	API key:
	<input type=text value="<?=$_['apkey'];?>" readonly />
	Hook receiver:

    <input type=text value="<?php echo OCP\Util::linkToAbsolute('index.php/apps','nkhooks/api_get/' . $_['apkey'] . '/topic', ['someVar' => 'someVal']); ?>" readonly />
      <ul >
          <li>
            <form method=post action="/index.php/apps/nkhooks/hooks_put">
              <ul>
                <li>
                  <h1>Add new hook.</h1>
                </li>
                <li>
                  <input type="text" name="name"  value="" placeholder="Name" />
                </li>
                <li>
                  <input type="text" name="url[]" value="" placeholder="Url"  />
                </li>
                <li>
                  <input type="text" name="url[]" value="" placeholder="Url"  />
                </li>
                <li>
                  <input type="text" name="url[]" value="" placeholder="Url"  />
                </li>
                <li>
                  <input type="text" name="pin"   value="" placeholder="PIN"  />
                </li>
                <li>
                  <input type="submit" value="Submit new hook" />
                </li>
              </ul>
            </form>
          </li>
          <li>
            <form method=post action="/index.php/apps/nkhooks/hooks_delete">
              <ul>
                <li>
                  <h1> Delete hooks from list.</h1>
                </li>
                <li>
                  <input type="text" name="name"  value="" placeholder="Name to delete" />
                </li>
                  <input type="submit" value="Delete" />
                </li>
              </ul>
            </form>
          </li>
          <li>
            <form method=post action="/index.php/apps/nkhooks/hooks_export">
              <ul>
                <li>
                  <h1> Export hooks settings.</h1>
                </li>
                  <input type="submit" value="Export" />
                </li>
              </ul>
            </form>
          </li>
          <li>

            <form method="post" enctype="multipart/form-data" action="/index.php/apps/nkhooks/hooks_import">
              <ul>
                <li>
                  <h1> Import hooks settings.</h1>
                </li>
                <li>
                  <input type="file" name="import"  value="" placeholder="Import file" />
                </li>
                  <input type="submit" value="Inport" />
                </li>
              </ul>
            </form>
          </li>

      </ul>
	</div>
</div>
