<header class="ph">
	<div class="pwr">
		<div class="pct">
			<a href="{{ RS }}" class="logo"><img src="{{ IMG.'icons-general/logo.svg' }}" alt="Bankrate"></a>
			<nav class="js_menu">
				<ul>
					
					@foreach ($nav->where('parent', 0)->where('display_in_header', 1) as $item)
						<li>
							<?php 
								$link = "";
								if ($item->type == 1) {
									$link = RS.LANG.$item->alias;
									if($item->alias == 'home') $link = RS.LANG;
								}else{
									$link = RS.LANG.'page/'.$item->alias;
								}
							?>
							<a href="{{ $link }}"><span>{{ $item->name }}</span></a>
							<?php 
								$children = $nav->where('parent', $item->id);
							?>
							@if (count($children) > 0)
								<div class="submenu">
									<div class="cols">
										<?php 
											$cnt = 0;
											foreach ($children->where('display_in_header', 1) as $key => $child) {
												$link = "";
												if ($child->type == 1) {
													$link = RS.LANG.$child->alias;
													if($child->alias == 'home') $link = RS.LANG;
												}else{
													$link = RS.LANG.'page/'.$child->alias;
												}
												if($cnt == 0) { ?>  <div class="col"> <?php } ?>
													 <a href="{{ $link }}">{{ $child->name }}</a> 

												<?php 
												$cnt++;
												if($cnt == 7) { ?> </div> <?php $cnt = 0; }
											}	
										?>
										
									</div>
								</div>
							@endif
						</li>
					@endforeach
				</ul>
			</nav>
			<div class="right">
				<button type="button" class="btn btn-orange-big btn-meet"><span>Meet with an Advisor</span></button>
				<div class="btn-burger js_menu-btn"><span></span></div>
			</div>
		</div>
	</div>
</header>