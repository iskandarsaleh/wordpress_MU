$.fn.magnify = function(options) {
	return this.each(function() {
		new $.ui.magnifier(this,options);	
	});
};


$.ui.magnifier = function(el,options) {
	
	var self = this;
	this.items = [];
	this.options = options ? options : {};
	this.element = el;
	var o = this.options;
	
	o.distance = o.distance ? o.distance : 150;
	o.magnification = o.magnification ? o.magnification : 2;
	o.baseline = o.baseline ? o.baseline : 0;
	o.verticalLine =  o.verticalLine != undefined ? o.verticalLine : -0.5;
	
	this.pp = $(el).offset({ border: false });
	
	$('> *', el).each(function() {
		var co = $(this).offset({ border: false });
		if(self.options.overlap) var cp = $(this).position();
		self.items.push([this, co, [$(this).width(),$(this).height()], (cp ? cp : null)]);
		
		if(o.opacity)
			$(this).css('opacity', o.opacity.min);	
	});

	if(o.overlap) {
		for(var i=0;i<this.items.length;i++) {
			//Absolute stuff
			$(this.items[i][0]).css({
				position: "absolute",
				top: this.items[i][3].top,
				left: this.items[i][3].left
			});
		};
	}
	
	$(document).bind("mousemove", function(e) {
		self.magnify.apply(self, [e]);
	});
	
	if(o.click) { //If onclick callback is available
		$(el).bind('click', function(e) {
			o.click.apply(this, [e, { options: self.options, current: self.current[0], currentOffset: self.current[1] }]);	
		})
	}
	
	if (o.name)
		$.ui.add(o.name, 'magnifier', this); //Append to UI manager if a name exists as option
	
}

$.extend($.ui.magnifier.prototype, {
	reset: function(e) {
		
		var o = this.options;
		var c;
		var distance = 1;
		
		for(var i=0;i<this.items.length;i++) {

			c = this.items[i];
			
			$(c[0]).css({
				width: c[2][0],
				height: c[2][1],
				top: (c[3] ? c[3].top : 0),
				left: (c[3] ? c[3].left : 0)
			});
			
			if(o.opacity)
				$(c[0]).css('opacity', o.opacity.min);
				
			if(o.zIndex)
				$(c[0]).css("z-index", "");
			
		}
				
	},
	magnify: function(e) {
		var p = [e.pageX,e.pageY];
		var o = this.options;
		var c;
		this.current = this.items[0];
		var distance = 1;

		//Compute the parents distance, because we don't need to fire anything if we are not near the parent

		var overlap = ((p[0] > this.pp.left-o.distance && p[0] < this.pp.left + this.element.offsetWidth + o.distance) && (p[1] > this.pp.top-o.distance && p[1] < this.pp.top + this.element.offsetHeight + o.distance));
		if(!overlap) return false;

		
		for(var i=0;i<this.items.length;i++) {
			c = this.items[i];
			
			var olddistance = distance;
			if(!o.axis) {
				distance = Math.sqrt(
					  Math.pow(p[0] - ((c[3] ? this.pp.left : c[1].left) + parseInt(c[0].style.left)) - (c[0].offsetWidth/2), 2)
					+ Math.pow(p[1] - ((c[3] ? this.pp.top  : c[1].top ) + parseInt(c[0].style.top )) - (c[0].offsetHeight/2), 2)
				);
			} else {
				if(o.axis == "y") {
					distance = Math.abs(p[1] - ((c[3] ? this.pp.top  : c[1].top ) + parseInt(c[0].style.top )) - (c[0].offsetHeight/2));
				} else {
					distance = Math.abs(p[0] - ((c[3] ? this.pp.left : c[1].left) + parseInt(c[0].style.left)) - (c[0].offsetWidth/2));
				}			
			}
			
			if(distance < o.distance) {

				this.current = distance < olddistance ? this.items[i] : this.current;
				
				if(!o.axis || o.axis != "y") {
					$(c[0]).css({
						width: c[2][0]+ (c[2][0] * (o.magnification-1)) - (((distance/o.distance)*c[2][0]) * (o.magnification-1)),
						left: (c[3] ? (c[3].left + o.verticalLine * ((c[2][1] * (o.magnification-1)) - (((distance/o.distance)*c[2][1]) * (o.magnification-1)))) : 0)
					});
				}
				
				if(!o.axis || o.axis != "x") {
					$(c[0]).css({
						height: c[2][1]+ (c[2][1] * (o.magnification-1)) - (((distance/o.distance)*c[2][1]) * (o.magnification-1)),
						top: (c[3] ? c[3].top : 0) + (o.baseline-0.5) * ((c[2][0] * (o.magnification-1)) - (((distance/o.distance)*c[2][0]) * (o.magnification-1)))
					});					
				}
				
				if(o.opacity)
					$(c[0]).css('opacity', o.opacity.max-(distance/o.distance) < o.opacity.min ? o.opacity.min : o.opacity.max-(distance/o.distance));
				
			} else {
				
				$(c[0]).css({
					width: c[2][0],
					height: c[2][1],
					top: (c[3] ? c[3].top : 0),
					left: (c[3] ? c[3].left : 0)
				});
				
				if(o.opacity)
					$(c[0]).css('opacity', o.opacity.min);
							
			}
			
			if(o.zIndex)
				$(c[0]).css("z-index", "");

		}
		
		if(this.options.zIndex)
			$(this.current[0]).css("z-index", this.options.zIndex);
		
	}
});

