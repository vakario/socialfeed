azer
{if $feed_tweets}
<div id="social_feed_display" class="col-xs-12 col-sm-12 col-md-12">
	<div class="container">
		<div id="left_col">
		<p id="quote_haut">”</p>
		<p id="quote_bas">“</p>
		</div>
		<div id="log_social">
		<span><img class="replace-2x img-responsive" src="../modules/socialfeed/css/images/32/twitter2.png" alt="icone twitter"></span>
		</div>
		<div id="tw_feed">
			{foreach from=$feed_tweets item=tweet}
				<p class="col-xs-12 col-sm-12 col-md-12 tweet_text"><a target="_blank" href="http://twitter.com/{$tweet->user->screen_name}/status/{$tweet->id}">” {$tweet->text} “</a></p>
				<p class="col-xs-3 col-sm-3 col-md-3 date_post">Posté le {$tweet->created_at|substr:8:2} {$tweet->created_at|substr:4:3} {$tweet->created_at|substr:26:4} </p>
			{/foreach}
		</div>
	</div>
    {if $link_facebook != '' || $link_twitter != '' || $link_youtube != '' || $link_google_plus != '' || $link_pinterest != ''}
    <div id="socialfeed_block">
    	<em class="icon-share-alt"></em>
        <h4 class="title_join">{l s='Join us' mod='socialfeed'}</h4>
        <ul>
            {if $link_facebook != ''}<li class="facebook"><a href="{$link_facebook|escape:html:'UTF-8'}" target="_blank">{l s='Facebook' mod='socialfeed'}</a></li>{/if}
            {if $link_twitter != ''}<li class="twitter"><a href="{$link_twitter|escape:html:'UTF-8'}" target="_blank">{l s='Twitter' mod='socialfeed'}</a></li>{/if}
            {if $link_youtube != ''}<li class="youtube"><a href="{$link_youtube|escape:html:'UTF-8'}" target="_blank">{l s='YouTube' mod='socialfeed'}</a></li>{/if}
            {if $link_google_plus != ''}<li class="google_plus"><a href="{$link_google_plus|escape:html:'UTF-8'}" target="_blank">{l s='Google+' mod='socialfeed'}</a></li>{/if}
            {if $link_pinterest != ''}<li class="pinterest"><a href="{$link_pinterest|escape:html:'UTF-8'}" target="_blank">{l s='Pinterest' mod='socialfeed'}</a></li>{/if}
			{if $link_instagram != ''}<li class="instagram"><a href="{$link_instagram|escape:html:'UTF-8'}" target="_blank">{l s='Instagram' mod='socialfeed'}</a></li>{/if}
        </ul>
    </div>
    {/if}
</div>
{/if}
{addJsDefL name=seemore}{l s='See More' mod='socialfeed' js=1}{/addJsDefL}