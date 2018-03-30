<div class="js_scroller">
    <ul>
        {foreach $results as $result}
            {if $result['type'] == "user"}
                {include file='__feeds_user.tpl' _user=$result _connection=$result['connection'] _search=true}

            {/if}
        {/foreach}
    </ul>
</div>
