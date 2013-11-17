			<div class="search-box">
				<div class="search-box-inner">						
					<div class="row-fluid">		
						<p class="intro">Start planning your trip...</p>
						<div class="radio-button-group way">
							<label class="radio span4">
								<input type="radio" name="optionsRadios" id="one-way" value="option1" onclick="functionOneway()">One way
							</label>
							<label class="radio span4">
								<input type="radio" name="optionsRadios" id="round-trip" value="option2" onclick="functionRoundtrip()">Round trip
							</label>								
							<label class="radio span4">
								<input type="radio" name="optionsRadios" id="multi-city" value="option3" onclick="functionMulticity()">Multi city
							</label>
						</div>
						<form id="one-way-form" class="search-form  hide-all" method="post" style="display:block" > 								
							<fieldset class="row-fluid">	
								<div class="flight-inputs flight-from span6">
									<input type="text" autocomplete="off" class="autocomplete city"  id="city-from" data-items="4" placeholder="From">
									<div class="date-time date-from">
										<input type="text" id="" class="datepicker flight-date" placeholder="Date"/>																			
										<label class="time">
											<select class="selectpicker">
												<option value="00:00-00:00">Anytime</option>
												<option value="00:00-10:00">Morning</option>
												<option value="10:00-20:00">Noon</option>
												<option value="12:00-16:00">Afternoon</option>
												<option value="20:00-00:00">Late Night</option>
												<option value="00:00-01:00">12AM</option>
												<option value="01:00-02:00">1AM</option>
												<option value="02:00-03:00">2AM</option>
												<option value="03:00-04:00">3AM</option>
												<option value="04:00-05:00">4AM</option>
												<option value="05:00-06:00">5AM</option>
												<option value="06:00-07:00">6AM</option>
												<option value="07:00-08:00">7AM</option>
												<option value="08:00-09:00">8AM</option>
												<option value="09:00-10:00">9AM</option>
												<option value="10:00-11:00">10AM</option>
												<option value="11:00-12:00">11AM</option>
												<option value="12:00-13:00">12AM</option>
												<option value="13:00-14:00">1AM</option>
												<option value="14:00-15:00">2PM</option>
												<option value="15:00-16:00">3PM</option>
												<option value="16:00-17:00">4PM</option>
												<option value="17:00-18:00">5PM</option>
												<option value="18:00-19:00">6PM</option>
												<option value="19:00-20:00">7PM</option>
												<option value="20:00-21:00">8PM</option>
												<option value="21:00-22:00">9PM</option>
												<option value="22:00-23:00">10PM</option>
												<option value="23:00-00:00">11PM</option>
											</select>
										</label>											
									</div>									
								</div>									
								<div class="flight-inputs flight-to span6">
									<input type="text" autocomplete="off" class="autocomplete city"  id="city-to" data-items="4" placeholder="To">																		
								</div>									
							</fieldset>		
						</form>
						<form id="round-trip-form" class="search-form  hide-all" method="post" style="display:none" > 								
							<fieldset class="row-fluid">	
								<div class="flight-inputs flight-from span6">
									<input type="text" autocomplete="off" class="autocomplete city"  id="city-from" data-items="4" placeholder="From">
									<div class="date-time date-from">
										<input type="text" id="" class="datepicker flight-date" placeholder="Date"/>																			
										<label class="time">
											<select class="selectpicker">
												<option value="00:00-00:00">Anytime</option>
												<option value="00:00-10:00">Morning</option>
												<option value="10:00-20:00">Noon</option>
												<option value="12:00-16:00">Afternoon</option>
												<option value="20:00-00:00">Late Night</option>
												<option value="00:00-01:00">12AM</option>
												<option value="01:00-02:00">1AM</option>
												<option value="02:00-03:00">2AM</option>
												<option value="03:00-04:00">3AM</option>
												<option value="04:00-05:00">4AM</option>
												<option value="05:00-06:00">5AM</option>
												<option value="06:00-07:00">6AM</option>
												<option value="07:00-08:00">7AM</option>
												<option value="08:00-09:00">8AM</option>
												<option value="09:00-10:00">9AM</option>
												<option value="10:00-11:00">10AM</option>
												<option value="11:00-12:00">11AM</option>
												<option value="12:00-13:00">12AM</option>
												<option value="13:00-14:00">1AM</option>
												<option value="14:00-15:00">2PM</option>
												<option value="15:00-16:00">3PM</option>
												<option value="16:00-17:00">4PM</option>
												<option value="17:00-18:00">5PM</option>
												<option value="18:00-19:00">6PM</option>
												<option value="19:00-20:00">7PM</option>
												<option value="20:00-21:00">8PM</option>
												<option value="21:00-22:00">9PM</option>
												<option value="22:00-23:00">10PM</option>
												<option value="23:00-00:00">11PM</option>
											</select>
										</label>											
									</div>					
								</div>									
								<div class="flight-inputs flight-to span6">
									<input type="text" autocomplete="off" class="autocomplete city"  id="city-to" data-items="4" placeholder="To">
									<div class="date-time date-to">
										<input type="text" id="" class="datepicker flight-date" placeholder="Date"/>																			
										<label class="time">
											<select class="selectpicker">
												<option value="00:00-00:00">Anytime</option>
												<option value="00:00-10:00">Morning</option>
												<option value="10:00-20:00">Noon</option>
												<option value="12:00-16:00">Afternoon</option>
												<option value="20:00-00:00">Late Night</option>
												<option value="00:00-01:00">12AM</option>
												<option value="01:00-02:00">1AM</option>
												<option value="02:00-03:00">2AM</option>
												<option value="03:00-04:00">3AM</option>
												<option value="04:00-05:00">4AM</option>
												<option value="05:00-06:00">5AM</option>
												<option value="06:00-07:00">6AM</option>
												<option value="07:00-08:00">7AM</option>
												<option value="08:00-09:00">8AM</option>
												<option value="09:00-10:00">9AM</option>
												<option value="10:00-11:00">10AM</option>
												<option value="11:00-12:00">11AM</option>
												<option value="12:00-13:00">12AM</option>
												<option value="13:00-14:00">1AM</option>
												<option value="14:00-15:00">2PM</option>
												<option value="15:00-16:00">3PM</option>
												<option value="16:00-17:00">4PM</option>
												<option value="17:00-18:00">5PM</option>
												<option value="18:00-19:00">6PM</option>
												<option value="19:00-20:00">7PM</option>
												<option value="20:00-21:00">8PM</option>
												<option value="21:00-22:00">9PM</option>
												<option value="22:00-23:00">10PM</option>
												<option value="23:00-00:00">11PM</option>
											</select>
										</label>											
									</div>
								</div>									
							</fieldset>		
						</form>
						<form id="multi-city-form" class="search-form  hide-all" method="post" style="display:none" > 	
							<p style="display:block;text-align:center;color:#444444">Step1</p>
							<fieldset class="row-fluid">	
								<div class="flight-inputs flight-from span6">
									<input type="text" autocomplete="off" class="autocomplete city"  id="city-from" data-items="4" placeholder="From">
									<div class="date-time date-from">
										<input type="text" id="" class="datepicker flight-date" placeholder="Date"/>																			
										<label class="time">
											<select class="selectpicker">
												<option value="00:00-00:00">Anytime</option>
												<option value="00:00-10:00">Morning</option>
												<option value="10:00-20:00">Noon</option>
												<option value="12:00-16:00">Afternoon</option>
												<option value="20:00-00:00">Late Night</option>
												<option value="00:00-01:00">12AM</option>
												<option value="01:00-02:00">1AM</option>
												<option value="02:00-03:00">2AM</option>
												<option value="03:00-04:00">3AM</option>
												<option value="04:00-05:00">4AM</option>
												<option value="05:00-06:00">5AM</option>
												<option value="06:00-07:00">6AM</option>
												<option value="07:00-08:00">7AM</option>
												<option value="08:00-09:00">8AM</option>
												<option value="09:00-10:00">9AM</option>
												<option value="10:00-11:00">10AM</option>
												<option value="11:00-12:00">11AM</option>
												<option value="12:00-13:00">12AM</option>
												<option value="13:00-14:00">1AM</option>
												<option value="14:00-15:00">2PM</option>
												<option value="15:00-16:00">3PM</option>
												<option value="16:00-17:00">4PM</option>
												<option value="17:00-18:00">5PM</option>
												<option value="18:00-19:00">6PM</option>
												<option value="19:00-20:00">7PM</option>
												<option value="20:00-21:00">8PM</option>
												<option value="21:00-22:00">9PM</option>
												<option value="22:00-23:00">10PM</option>
												<option value="23:00-00:00">11PM</option>
											</select>
										</label>											
									</div>
								</div>									
								<div class="flight-inputs flight-to span6">
									<input type="text" autocomplete="off" class="autocomplete city"  id="city-to" data-items="4" placeholder="To">
								</div>									
							</fieldset>	
							<p style="display:block;text-align:center;color:#444444">Step2</p>
							<fieldset class="row-fluid">	
								<div class="flight-inputs flight-to span6">
									<input type="text" autocomplete="off" class="autocomplete city"  id="city-to" data-items="4" placeholder="From">
									<div class="date-time date-to">
										<input type="text" id="" class="datepicker flight-date" placeholder="Date"/>																			
										<label class="time">
											<select class="selectpicker">
												<option value="00:00-00:00">Anytime</option>
												<option value="00:00-10:00">Morning</option>
												<option value="10:00-20:00">Noon</option>
												<option value="12:00-16:00">Afternoon</option>
												<option value="20:00-00:00">Late Night</option>
												<option value="00:00-01:00">12AM</option>
												<option value="01:00-02:00">1AM</option>
												<option value="02:00-03:00">2AM</option>
												<option value="03:00-04:00">3AM</option>
												<option value="04:00-05:00">4AM</option>
												<option value="05:00-06:00">5AM</option>
												<option value="06:00-07:00">6AM</option>
												<option value="07:00-08:00">7AM</option>
												<option value="08:00-09:00">8AM</option>
												<option value="09:00-10:00">9AM</option>
												<option value="10:00-11:00">10AM</option>
												<option value="11:00-12:00">11AM</option>
												<option value="12:00-13:00">12AM</option>
												<option value="13:00-14:00">1AM</option>
												<option value="14:00-15:00">2PM</option>
												<option value="15:00-16:00">3PM</option>
												<option value="16:00-17:00">4PM</option>
												<option value="17:00-18:00">5PM</option>
												<option value="18:00-19:00">6PM</option>
												<option value="19:00-20:00">7PM</option>
												<option value="20:00-21:00">8PM</option>
												<option value="21:00-22:00">9PM</option>
												<option value="22:00-23:00">10PM</option>
												<option value="23:00-00:00">11PM</option>
											</select>
										</label>											
									</div>								
								</div>									
								<div class="flight-inputs flight-to span6">
									<input type="text" autocomplete="off" class="datepicker autocomplete city"  id="city-to" data-items="4" placeholder="To">
								</div>									
							</fieldset>	
							<a href="" class="add" style="display:block;text-align:center;color:#444444"><span class="add-icon"></span>Click to add city</a>
						</form>
						
						<p style="text-align:center;display:block;font-size:18px;margin:30px 0 20px 0">Select the number of passengers</p>
						<div class="row-fluid passenger-num passengers ">									
									<div class="">
										<p><span class="passenger-icon adult-icon"></span>Adults</p>
										<label>
										<select id="pAdults" class="selectpicker span12" size="auto" name="pAdults">
											<option value="0">0</option>
											<option value="1" selected="selected">1</option>
											<option value="2">2</option>
											<option value="3">3</option>
											<option value="4">4</option>
											<option value="5">5</option>
											<option value="6">6</option>
										</select>
										</label>											
									</div>
									<div class="">
										<p><span class="passenger-icon student-icon"></span>Student</p>
										<label>
										<select id="pAdults" class="selectpicker span12" size="auto" name="pAdults">
											<option value="0">0</option>
											<option value="1" selected="selected">1</option>
											<option value="2">2</option>
											<option value="3">3</option>
											<option value="4">4</option>
											<option value="5">5</option>
											<option value="6">6</option>
										</select>
										</label>
									</div>
									
									<div class="">
										<p><span class="passenger-icon child-icon"></span>Child</p>
										<label>
										<select id="pAdults" class="selectpicker span12" size="auto" name="pAdults">
											<option value="0">0</option>
											<option value="1" selected="selected">1</option>
											<option value="2">2</option>
											<option value="3">3</option>
											<option value="4">4</option>
											<option value="5">5</option>
											<option value="6">6</option>
										</select>
										</label>
									</div>
						</div>	
						<form id="round-trip-form" class="hide-all" method="post" style="display:none">  Round trip </form>														
						<form id="multi-city-form" class="hide-all" method="post" style="display:none" > Muticity </form>
						
						<div class="row-fluid">
							<a href="#" class="button left">Click to clear all<span class="clear"></span></a>       
							<a href="#" class="button right">Click to search<span class="continue"></span></a>       
						</div>
						
					</div>
				</div><!--searchbox-->
			</div><!--searchbox-->
		</div><!--.header-->
		
		<div class="bestDeals gray-bg ">
			<div class="row-fluid deals-cus" style="position:relative;">				
				<div class="span12 nav ">	 
					<div class="span4 promotion-box" id="link1">
						<a onclick="toggle('list1');" class="click-to-show">Best Flights<span class="show-icon"></span></a>								
					</div>						
					<div class="span4 promotion-box" id="link2">
						<a onclick="toggle('list2');" class="click-to-show">Promotion<span class="show-icon"></span></a>							
					</div>						
					<div class="span4 promotion-box" id="link3">
						<a onclick="toggle('list3');" class="click-to-show">Top destinations<span class="show-icon"></span></a>						
					</div>
				</div>
					
				<div id="list1" class="list span12 tab-content best-flights" style="display:none;">
					<a class="best-deal-link span6 flight" href="#">								
						<div class="row-fluid">
							<div class="title">
								TP.HCM - ĐÀ NẴNG - HUẾ
								<br>
								<span>2 ngày 3 đêm</span>
							</div>
							<div class="fare">
								$50
								<span class="detail"></span>
							</div>
						</div>							
					</a>
					<a class="best-deal-link span6 flight" href="#">								
						<div class="row-fluid">
							<div class="title">
								TP.HCM - ĐÀ NẴNG - HUẾ
								<br>
								<span>2 ngày 3 đêm</span>
							</div>
							<div class="fare">
								$250
								<span class="detail"></span>
							</div>
						</div>							
					</a>
					<a class="best-deal-link span6 flight" href="#">								
						<div class="row-fluid">
							<div class="title">
								TP.HCM - ĐÀ NẴNG - HUẾ
								<br>
								<span>2 ngày 3 đêm</span>
							</div>
							<div class="fare">
								$350
								<span class="detail"></span>
							</div>
						</div>							
					</a>
					<a class="best-deal-link span6 flight" href="#">								
						<div class="row-fluid">
							<div class="title">
								TP.HCM - ĐÀ NẴNG - HUẾ
								<br>
								<span>2 ngày 3 đêm</span>
							</div>
							<div class="fare">
								$50
								<span class="detail"></span>
							</div>
						</div>							
					</a>
				</div>
				<div id="list2" class="list span12 tab-content promotion" style="display:none;">
					<a class="best-deal-link span6" href="#">								
						<div class="row-fluid">
							<div class="title">
								Toronto Elite Class Special to Taiwan & S.E. Asia
								<br>
								<span>2013/10/10 - 2013/11/02 </span>
							</div>
							<div class="fare">
								$150
								<span class="detail"></span>
							</div>
						</div>							
					</a>
					<a class="best-deal-link span6" href="#">								
						<div class="row-fluid">
							<div class="title">
								San Francisco to Taipei, S.E. Asia OCT Fares Starting from USD874*
								<br>
								<span>Travel Period:  03OCT13 to 20MAY14 </span>
							</div>
							<div class="fare">
								$50
								<span class="detail"></span>
							</div>
						</div>							
					</a>
					<a class="best-deal-link span6" href="#">								
						<div class="row-fluid">
							<div class="title">
								Great Deal from Vancouver to Asia 
								<br>
								<span>Travel Period: 07OCT2013-30NOV2013; 01JAN2014 - 31MAY2014</span>
							</div>
							<div class="fare">
								$50
								<span class="detail"></span>
							</div>
						</div>							
					</a>
					<a class="best-deal-link span6" href="#">								
						<div class="row-fluid">
							<div class="title">
								Travel in December to SUN Destinations with Fares Starting from CAD1130
								<br>
								<span>Travel Period: 01DEC - 24DEC, 2013</span>
							</div>
							<div class="fare">
								$50
								<span class="detail"></span>
							</div>
						</div>							
					</a>				
				</div>
				<div id="list3" class="list span12 tab-content destination" style="display:none;">												
					<div class="row-fluid">
						<a class="best-deal-link span6 row-fluid" href="#">		
							<div class="picture">
								<img src="public/images/destinations/san-francisco.jpg"/>
							</div>
							<div class="text title">	
								<h5>San Francisco, California</h5>
								<p>Lorem ipsum dolor sit amet, consectetuer adipiscing elit, sed diam nonummy nibh euismod..</p>
								<span class="detail"></span>
							</div>
						</a>	
						<a class="best-deal-link span6 row-fluid" href="#">		
							<div class="picture">
								<img src="public/images/destinations/new-york-city.jpg"/>
							</div>
							<div class="text title">											
								<h5>New York City, New York</h5>
								<p>Lorem ipsum dolor sit amet, consectetuer adipiscing elit, sed diam nonummy nibh euismod..</p>
								<span class="detail"></span>
							</div>
						</a>	
					</div>
					<div class="row-fluid">
						<a class="best-deal-link span6 row-fluid" href="#">		
							<div class="picture">
								<img src="public/images/destinations/washington-monument.jpg"/>
							</div>
							<div class="text title">											
								<h5>Washington Monument</h5>
								<p>Lorem ipsum dolor sit amet, consectetuer adipiscing elit, sed diam nonummy nibh euismod..</p>
								<span class="detail"></span>
							</div>
						</a>					
						
						<a class="best-deal-link span6 row-fluid" href="#">		
							<div class="picture">
								<img src="public/images/destinations/savannah.jpg"/>
							</div>
							<div class="text title">											
								<h5>Savannahk</h5>
								<p>Lorem ipsum dolor sit amet, consectetuer adipiscing elit, sed diam nonummy nibh euismod..</p>
								<span class="detail"></span>
							</div>
						</a>
					</div>
					<div class="row-fluid">	
						<a class="best-deal-link span6 row-fluid" href="#">		
							<div class="picture">
								<img src="public/images/destinations/new-orleans.jpg"/>
							</div>
							<div class="text title">											
								<h5>new Orleans</h5>
								<p>Lorem ipsum dolor sit amet, consectetuer adipiscing elit, sed diam nonummy nibh euismod..</p>
								<span class="detail"></span>
							</div>
						</a>	
					</div>													
				</div>
			</div>	
		</div>	
	</div>	
	
