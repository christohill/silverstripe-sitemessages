<% if SiteMessages %>
	<div class="sitemessage-container">
		<% loop SiteMessages %>
			<div id="{$Unique}" class="sitemessage" style="background-color:#{$BackgroundColor}; color:#{$TextColor}">
				<% if CanClose %>
					<div class="sitemessage-close">
						<a href="#"><i style="color:#{$CloseColor}" class="smicon-cross"></i></a>
					</div>
				<% end_if %>
				<div class="sitemessage-content">
					$Content
				</div>
				<div class="sitemessage-button">
					<a href="{$Page.Link}" style="background-color:#{$ButtonColor}; color:#{$ButtonTextColor}">$ButtonText</a>
				</div>
			</div>
		<% end_loop %>
	</div>
<% end_if %>