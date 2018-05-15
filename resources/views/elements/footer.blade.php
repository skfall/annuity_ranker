<footer class="pf">
	<div class="pwr">
		<div class="pct">
			<div class="top">
                <a href="{{ RS }}" class="logo"><img src="{{ IMG.'icons-general/logo-white.svg' }}" alt="Annuityrate"></a>
			</div>
			<div class="center">
				<div class="col col-left">
					<nav>
						<ul>
							@foreach ($nav->where('display_in_footer', 1) as $item)
							<?php 
								$link = "";
									if ($item->type == 1) {
										$link = RS.LANG.$item->alias;
										if($item->alias == 'home') $link = RS.LANG;
									}else{
										$link = RS.LANG.'page/'.$item->alias;
									}
								?>
								<li>
									<a href="{{ $link }}"><span>{{ $item->name }}</span></a>
								</li>
							@endforeach
						</ul>
					</nav>
				</div>
				<div class="col col-right">
					<div class="text">
						<h5>How we make money</h5>
						<p>
							Annuityrate.com is an independent, advertising-supported publisher and comparison service. Annuityrate is compensated in exchange for featured placement of sponsored products and services, or your clicking on links posted on this website. This compensation may impact how, where and in what order products appear. Annuityrate.com does not include all companies or all available products. 
						</p>
					</div>
				</div>
			</div>
			<div class="bottom">
				<div class="copyright">{{ $config->copyright }}</div>
				<div class="space5"></div>
				<div class="dev"><a href="https://kaminskiy-design.com.ua/" rel="me" target="_blank" style="font-size: 12px; line-height: 1.25; color: #fff;">Website development</a></div>
			</div>
		</div>
	</div>
</footer>