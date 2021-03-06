{include file='_head.tpl'}
{include file='_header.tpl'}

<!-- page content -->
<div class="container mt20 {if $user->_logged_in}offcanvas{/if}">
	<div class="row">

        <!-- side panel -->
        {if $user->_logged_in}
            <div class="col-xs-12 visible-xs-block offcanvas-sidebar mt20">
                {include file='_sidebar.tpl'}
            </div>
        {/if}
        <!-- side panel -->

        <div class="col-xs-12 {if $user->_logged_in}offcanvas-mainbar{/if}">
        	<div class="row">
        		<!-- left panel -->
				<div class="col-sm-8">
				{include file='__feeds_post.tpl' standalone=true}
				</div>
				<!-- left panel -->

        	</div>
        </div>

	</div>
</div>
<!-- page content -->

{include file='_footer.tpl'}
