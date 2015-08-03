import com.calendar.Constants;

class Calendar extends MovieClip {
	
	public static var symbolName:String =          
          "__Packages.Calendar";
	private static var symbolLinked=
          Object.registerClass(symbolName, Calendar)
	
	static var cal : Calendar;

	private var months = new Array("January", "February", "March", "April", "May", "June", "July", "August", "September", "October", "November", "December");

	//Calendar.prototype = new MovieClip();
	//Object.registerClass("CalendarSymbol", Calendar);
	private var lineColor = 0xEEEEEE;
	//0x666666;
	private var fillColor = 0xEEEEEE;
	private var buttonFillColor = 0x333333;
	private var alternateFillColor = 0xDDDDDD;
	private var monthBorder = 0x666666;
	private var activeTextColor = 0x000000;
	private var disabledTextColor = 0x666666;
	private var debug = true;
	private var width = 175;
	private var cellHeight = 18;
	private var daysTitles = new Array("Sun", "Mon", "Tue", "Wed", "Thu", "Fri", "Sat");
	private var thisObject = new Object();
	private var inHTML = true;
	private var font = "Tahoma, Arial, Helvetica";
	private var fontSize = 11;
	private var yearFontSize = 12;
	private var monthFontSize = 12;
	private var stepSize = 5;
	private var selectedMonth = 7;
	private var selectedYear = 2006;
	private var selectedDay = 1;
	private var hideMonthInterval = -1;
	private var dateFormat = "yyyy-mm-dd";
	//Movie clips 
	private var maskMonths:MovieClip;
	private var monthSelect:MovieClip;
	private var yearDisplay: MovieClip;
	private var monthDisplay: MovieClip;
	//private var monthMask: MovieClip;
	private var nextBtn: MovieClip;
	private var prevBtn: MovieClip;
	//TOD change to local variable 
	private var onDayOverURL;
	private var onDayPressURL;
	
	
	function Calendar() {
		//_root.createEmptyMovieClip("CalendarMC", this.getNextHighestDepth());
		//_root.CalendarMC = this;
		this.init();
	}
	
	private function init():Void {
		trace("init");
		this.myTrace("init");
		this.thisObject = this;
		this.drawBorder(0, 0, 185, 165);
		this.drawDays(5, 30, this.width, this.cellHeight);
		this.drawContentBack(5, 32, this.width, this.cellHeight);
		this.drawNavButtons(5, 13);
		//this.drawMonthName();
		this.drawYear(7);
		this.drawMonth(7);
		this.drawSelectMonth(30, 25, 100, 20);
		this.setYearMonth(2006, 0);
	}
	
	private function isLeapYear(year:Number) {
		this.myTrace("isLeapYear: "+year);
		if (((year%4) == 0) && ((year%100) != 0) || ((year%400) == 0)) {
			return (true);
		} else {
			return (false);
		}
	}

	private function updateJS():Void {
		var onDayPressURL = new Object();
		onDayPressURL = "javascript:setText('dateInputID', '" + this.getStrDate() + "');";
		if (this.inHTML == true) {
			getURL(onDayPressURL);
		}
	
	}

	private function getMonthDays(month:Number, year:Number) {
		this.myTrace("getMonthDays"+month+"_"+year);
		if (month == 0 || month == 2 || month == 4 || month == 6 || month == 7 || month == 9 || month == 11) {
			return 31;
		} else if (month == 3 || month == 5 || month == 8 || month == 10) {
			return 30;
		} else if (month == 1) {
			if (this.isLeapYear(year)) {
				return 29;
			} else {
				return 28;
			}
		}
		return 0;
	}

	private function getStrDate():String {
		var retStr:String = this.dateFormat;
		retStr = retStr.split("yyyy").join(this.selectedYear);
		var monthStr:String = (this.selectedMonth < 9) ? "0" + (this.selectedMonth + 1) : (this.selectedMonth + 1);
		retStr = retStr.split("mm").join(monthStr); 
		var dayStr:String = (this.selectedDay < 10) ? "0" + this.selectedDay : this.selectedDay;
		retStr = retStr.split("dd").join(dayStr);
		return retStr;
	}

	private function setYearMonth(year:Number, month:Number):Void {
		this.myTrace("setYearMonth");
		if (month == 12) {
			year = year+1;
			month = 0;
		}
		if (month == -1) {
			month = 11;
			year = year-1;
		}
		var prevMonth = month-1;
		var nextMonth = month+1;
		if (month == 0) {
			prevMonth = 11;
		}
		if (month == 11) {
			nextMonth = 0;
		}
		this.setMonth(month);
		this.setYear(year);
		this.updateJS();
		var given_date:Date = new Date(year, month, 1);
		this.drawDaysNumbers(this.getMonthDays(prevMonth, year), given_date.getUTCDay()+1, this.getMonthDays(month, year));
	}
	private function drawBorder(x:Number, y:Number, width:Number, height:Number):Void {
		this.myTrace("drawBorder");
		this.drawRectangle(this, 0xA2D0FF, 0x0066FF, y, x, width, height);
	}
	private function drawSelectMonth(x:Number, y:Number, width:Number, height:Number):Void {
		this.myTrace("drawSelectMonth");
		var my_fmt:TextFormat = new TextFormat();
		my_fmt.color = this.activeTextColor;
		my_fmt.font = this.font;
		my_fmt.bold = false;
		my_fmt.size = this.monthFontSize;
		my_fmt.align = "left";
		var itemHeight = 18;
		var itemWidth = 85;
		var offset = 5;
		thisObject = this;
		this.createEmptyMovieClip("maskMonths", this.getNextHighestDepth());
		//this.maskMonths = new MovieClip();
		this.maskMonths.createEmptyMovieClip("bkg", this.maskMonths.getNextHighestDepth());
		this.drawRectangle(this.maskMonths.bkg, 0xEEEEEE, this.lineColor, x, y + 1, itemWidth, itemHeight*6 );
		this.createEmptyMovieClip("monthSelect", this.getNextHighestDepth());
		this.monthSelect.createEmptyMovieClip("bkg", this.monthSelect.getNextHighestDepth());
		this.monthSelect.setMask(this.maskMonths);
		this.drawRectangle(this.monthSelect.bkg, 0xEEEEEE, this.monthBorder, x, y + 1, itemWidth - 1, itemHeight*6 - 1);
		this.hideMonthInterval = -1;
		for (var i = 0; i<Constants.MONTHS.length; i++) {
			this.monthSelect.createEmptyMovieClip("monthSelectItem_"+i, this.monthSelect.getNextHighestDepth());
			this.monthSelect["monthSelectItem_"+i].createEmptyMovieClip("bkg", this.monthSelect["monthSelectItem_"+i].getNextHighestDepth());
			this.drawRectangle(this.monthSelect["monthSelectItem_"+i].bkg, 0xB4DFF3, this.lineColor, x + 2, y+itemHeight*i+offset + 2, itemWidth - 5, itemHeight - 2);
			this.monthSelect["monthSelectItem_"+i].bkg._alpha = 0;
			this.monthSelect["monthSelectItem_"+i].monthIndex = i;
			this.monthSelect["monthSelectItem_"+i].monthName = Constants.MONTHS[i];
			this.monthSelect["monthSelectItem_"+i].createTextField("monthText", this.getNextHighestDepth(), x + 5, y+itemHeight*i+offset, itemWidth - 10, itemHeight);
			this.monthSelect["monthSelectItem_"+i].monthText.text = Constants.MONTHS[i];
			this.monthSelect["monthSelectItem_"+i].monthText.setTextFormat(my_fmt);
			this.monthSelect["monthSelectItem_"+i].monthText.selectable = false;
			this.monthSelect["monthSelectItem_"+i].monthText.embedFonts = false;
			this.monthSelect["monthSelectItem_"+i].onPress = function() {
				//trace(this.monthName + " " + this.monthIndex);
				this._parent._parent.showSelectMonth(false);
				this.bkg._alpha = 0;
				this._parent._parent.setYearMonth(this._parent._parent.selectedYear, this.monthIndex);
			};
			this.monthSelect["monthSelectItem_"+i].onRollOut = function() {
				//trace("onRollOut: " + this.monthName + " " + this.monthIndex);
				this.bkg._alpha = 0;
				this._parent._parent.hideMonthInterval = setInterval(this._parent._parent, "showSelectMonth", 1000, false);
			};
			this.monthSelect["monthSelectItem_"+i].onRollOver = function() {
				//trace(this.monthName + " " + this.monthIndex);
				clearInterval(this._parent._parent.hideMonthInterval);
				this.bkg._alpha = 70;
			};
		}
		this.monthSelect.createEmptyMovieClip("buttonUp", this.monthSelect.getNextHighestDepth());
		this.drawTriangle(this.monthSelect.buttonUp, this.buttonFillColor, this.lineColor, 0, 0, 12, 12);
		this.monthSelect.buttonUp._rotation = 90;
		this.monthSelect.buttonUp._x = x + 82 ;
		this.monthSelect.buttonUp._y = y + itemHeight*6 - 18;
		
		
		this.monthSelect.buttonUp.onRelease = function() {
			clearInterval(this._parent.downIntervalID);
			this._parent.downIntervalID = -1;
		};
		
		this.monthSelect.buttonUp.onReleaseOutside = function() {
			clearInterval(this._parent.downIntervalID);
			this._parent.downIntervalID = -1;
		};
		
		this.monthSelect.buttonUp.onRollOver = function() {
			clearInterval(this._parent._parent.hideMonthInterval);
		};
		this.monthSelect.buttonUp.onRollOut = function() {
			this._parent._parent.hideMonthInterval = setInterval(this._parent._parent, "showSelectMonth", 1000, false);
		};
		this.monthSelect.moveDown = function() {
			if (this.bkg._y<=0) {
				clearInterval(this._parent.downIntervalID);
				this._parent.downIntervalID = -1;
				return;
			}
			this._y += this._parent.thisObject.stepSize;
			this.buttonUp._y -=  this._parent.thisObject.stepSize;
			this.buttonDown._y -=  this._parent.thisObject.stepSize;
			this.bkg._y -=  this._parent.thisObject.stepSize;
		};
		this.monthSelect.moveUp = function() {
			if (this.bkg._y>115) {
				clearInterval(this._parent.upIntervalID);
				this._parent.upIntervalID = - 1;
				return;
			}
			this._y -=  this._parent.thisObject.stepSize;
			this.buttonUp._y +=  this._parent.thisObject.stepSize;
			this.buttonDown._y +=  this._parent.thisObject.stepSize;
			this.bkg._y +=  this._parent.thisObject.stepSize;
		};
		this.monthSelect.buttonUp.onPress = function() {
			if(this._parent._parent.monthSelect.downIntervalID == -1)
			{
				this._parent._parent.monthSelect.downIntervalID = setInterval(this._parent._parent.monthSelect, "moveUp", 10);
			}
		};
		this.monthSelect.createEmptyMovieClip("buttonDown", this.monthSelect.getNextHighestDepth());
		//this.drawTriangle(this.monthSelect.buttonDown, this.buttonFillColor, this.lineColor, 0, 0, 12, 12);//0, -70, 10, itemWidth);
		//this.monthSelect.buttonDown._y = 18 + y;
		//this.monthSelect.buttonDown._x = 70 + x;
		this.drawTriangle(this.monthSelect.buttonDown, this.buttonFillColor, this.lineColor, 0, 0, 12, 12);
		this.monthSelect.buttonDown._rotation = -90;
		this.monthSelect.buttonDown._x = x + 70 ;
		this.monthSelect.buttonDown._y = y + 18;
		this.monthSelect.buttonDown.onRelease = function() {
			clearInterval(this._parent.upIntervalID);
			this._parent.upIntervalID = -1;
		};
		
		this.monthSelect.buttonDown.onReleaseOutside = function() {
			clearInterval(this._parent.upIntervalID);
			this._parent.upIntervalID = -1;
		};
		this.monthSelect.buttonDown.onPress = function() {
			if(this._parent._parent.monthSelect.upIntervalID == -1)
			{
				this._parent._parent.monthSelect.upIntervalID = setInterval( this._parent._parent.monthSelect, "moveDown", 10);
			}
		};
		this.monthSelect.buttonDown.onRollOver = function() {
			clearInterval(this._parent._parent.hideMonthInterval);
		};
		this.monthSelect.buttonDown.onRollOut = function() {
			this._parent._parent.hideMonthInterval = setInterval(this._parent._parent, "showSelectMonth", 1000, false);
		};
		this.showSelectMonth(false);
	}
	private function drawYear(y:Number):Void {
		this.myTrace("drawYear");
		//this.yearDisplay = new MovieClip();
		this.createEmptyMovieClip("yearDisplay", this.getNextHighestDepth());
		this.yearDisplay.createTextField("yearInput", this.getNextHighestDepth(), 105, 0+y, 40, 18);
		this.yearDisplay.yearInput.text = "";
		this.yearDisplay.yearInput.border = true;
		this.yearDisplay.yearInput.borderColor = 0x0066CC;
		var my_fmt:TextFormat = new TextFormat();
		my_fmt.color = this.activeTextColor;
		my_fmt.font = this.font;
		my_fmt.bold = true;
		my_fmt.size = this.yearFontSize;
		my_fmt.align = "center";
		this.yearDisplay.yearInput.type = "input";
		this.yearDisplay.yearInput.setTextFormat(my_fmt);
		this.yearDisplay.yearInput.selectable = true;
		this.yearDisplay.yearInput.embedFonts = false;
		this.yearDisplay.yearInput.onChanged = function() {
			trace(this.text);
			if (this.text.length == 4 && Number(this.text)>1900 && Number(this.text)<2200) {
				this.yearDisplay.yearInput.text = Number(this.text);
				this._parent._parent.setYearMonth(new Number(this.text), this._parent._parent.selectedMonth);
			}
		};
	}
	private function setYear(year):Void {
		this.selectedYear = year;
		this.yearDisplay.yearInput.text = year;
		var txtFrm = this.yearDisplay.yearInput.getTextFormat();
		txtFrm.bold = true;
		txtFrm.color = this.activeTextColor;
		txtFrm.font = this.font;
		txtFrm.size = this.yearFontSize;
		txtFrm.align = "left";
		this.yearDisplay.yearInput.setTextFormat(txtFrm);
	}
	private function setMonth(month):Void {
		this.selectedMonth = month;
		this.monthDisplay.monthInput.text = Constants.MONTHS[month];
		var txtFrm = this.monthDisplay.monthInput.getTextFormat();
		txtFrm.bold = true;
		txtFrm.color = this.activeTextColor;
		txtFrm.font = this.font;
		txtFrm.size = this.yearFontSize;
		txtFrm.align = "center";
		this.monthDisplay.monthInput.setTextFormat(txtFrm);
	}
	private function drawMonth(y:Number):Void {
		this.myTrace("drawMonth");
		this.createEmptyMovieClip("monthDisplay", this.getNextHighestDepth());
		//this.monthDisplay = new MovieClip();
		this.monthDisplay.createTextField("monthInput", this.getNextHighestDepth(), 30, 0+y, 70, 18);
		this.monthDisplay.monthInput.text = "July";
		var my_fmt:TextFormat = new TextFormat();
		my_fmt.color = this.activeTextColor;
		my_fmt.font = this.font;
		my_fmt.bold = true;
		my_fmt.size = this.monthFontSize;
		my_fmt.align = "center";
		//this.yearDisplay.yearInput.type = "input";
		this.monthDisplay.monthInput.setTextFormat(my_fmt);
		this.monthDisplay.monthInput.selectable = false;
		this.monthDisplay.monthInput.embedFonts = false;
		this.monthDisplay.onPress = function() {
			this._parent.thisObject.myTrace("monthDisplay: onPress");
			this._parent.showSelectMonth(true);
		};
	}
	private function showSelectMonth(p_show:Boolean) {
		this.myTrace("showSelectMonth"+this.hideMonthInterval);
		clearInterval(this.hideMonthInterval);
		this.monthSelect._visible = p_show;
		//this.monthMask._visible = p_show;
	}
	private function drawNavButtons(x:Number, y:Number):Void {
		this.myTrace("drawNavButtons");
		this.createEmptyMovieClip("nextBtn", this.getNextHighestDepth());
		//this.nextBtn = new MovieClip();
		this.drawTriangle(this.nextBtn, this.fillColor, this.lineColor, 165+x, y, 8, 8);
		//this.prevBtn = new MovieClip();
		this.createEmptyMovieClip("prevBtn", this.getNextHighestDepth());
		this.drawTriangle(this.prevBtn, this.fillColor, this.lineColor, 10+x, y, -8, 8);
		this.nextBtn.onRollOver = function() {
			this._parent.thisObject.myTrace("onRollover");
		};
		this.prevBtn.onRollOver = function() {
			this._parent.thisObject.myTrace("onRollover");
		};
		this.nextBtn.onPress = function() {
			this._parent.thisObject.myTrace("NextBtn: onPress"+(this._parent.selectedMonth+1));
			this._parent.setYearMonth(this._parent.selectedYear, (this._parent.selectedMonth+1));
		};
		this.prevBtn.onPress = function() {
			this._parent.thisObject.myTrace("PrevtBtn: onPress"+(this._parent.selectedMonth-1));
			this._parent.setYearMonth(this._parent.selectedYear, (this._parent.selectedMonth-1));
		};
	}
	private function drawDaysNames(x:Number, y:Number, width:Number, height:Number, offset:Number):Void {
		this.myTrace("drawDaysNames");
		var smallWidth = width/7;
		var my_fmt:TextFormat = new TextFormat();
		my_fmt.color = this.activeTextColor;
		my_fmt.font = this.font;
		my_fmt.size = this.fontSize;
		my_fmt.align = "center";
		for (var i = 0; i<this.daysTitles.length; i++) {
			var currentX = i*smallWidth+offset;
			this.createTextField(this.daysTitles[i], this.getNextHighestDepth(), currentX+x, y, smallWidth, height);
			this[this.daysTitles[i]].text = this.daysTitles[i];
			this[this.daysTitles[i]].selectable = false;
			this[this.daysTitles[i]].embedFonts = false;
			this[this.daysTitles[i]].kerning = true;
			this[this.daysTitles[i]].setTextFormat(my_fmt);
		}
	}
	private function drawDaysLines(x:Number, y:Number, width:Number, height:Number, lastMonthDayEnd:Number, dayStartIndex:Number, monthDayEnd:Number):Void {
		this.myTrace("drawDaysLines");
		var smallWidth = width/7;
		var i = 0;
		var currentDay = 1;
		var nextMonthDay = 1;
		var lastMonthDay = lastMonthDayEnd-dayStartIndex;
		for (var j = 0; j<6; j++) {
			for (i=0; i<7; i++) {
				var color = this.alternateFillColor;
				if (i%2 == 0) {
					color = this.fillColor;
				}
				var currentX = x+i*smallWidth;
				var currentY = y+(j+1)*height;
				var mvName = "day_"+i+"_"+j;
				this.createEmptyMovieClip(mvName, this.getNextHighestDepth());
				this.drawRectangle(this[mvName], color, this.lineColor, currentX, currentY, smallWidth, height);
				this[mvName].createTextField("dayTitle", this.getNextHighestDepth(), currentX, currentY, smallWidth-2, height-2);
			}
		}
		this.drawDaysNumbers(lastMonthDayEnd, dayStartIndex, monthDayEnd);
	}
	private function drawDaysNumbers(lastMonthDayEnd:Number, dayStartIndex:Number, monthDayEnd:Number) {
		//thisObject = this;
		var my_fmt:TextFormat = new TextFormat();
		my_fmt.color = this.activeTextColor;
		my_fmt.font = this.font;
		my_fmt.size = this.fontSize;
		my_fmt.align = "center";
		var i = 0;
		var currentDay = 1;
		var nextMonthDay = 1;
		var lastMonthDay = lastMonthDayEnd-dayStartIndex;
		for (var j = 0; j<6; j++) {
			for (i=0; i<7; i++) {
				var mvName = "day_"+i+"_"+j;
				this[mvName].dayNumber = 0;
				if (lastMonthDay<lastMonthDayEnd) {
					this[mvName].dayTitle.text = lastMonthDay+1;
					lastMonthDay++;
					my_fmt.color = this.disabledTextColor;
				} else if (currentDay<=monthDayEnd) {
					this[mvName].dayNumber = currentDay;
					this[mvName].dayTitle.text = currentDay++;
					my_fmt.color = this.activeTextColor;
				} else {
					this[mvName].dayTitle.text = nextMonthDay++;
					my_fmt.color = this.disabledTextColor;
				}
				this[mvName].name = mvName;
				this[mvName].onRollOut = function() {
					this._parent.thisObect.myTrace("onRollOut: "+this.name);
					if(this.selectedDay != this.dayNumber)
					{
						this.dayTitle.border = false;
					}
				};
				this[mvName].onReleaseOutside = function() {
					this._parent.thisObect.myTrace("onRollOut: "+this.name);
					if(this.selectedDay != this.dayNumber)
					{
						this.dayTitle.border = false;
					}
				};
				this[mvName].onRollOver = function() {
					this._parent.thisObject.myTrace("OnRollOver: "+this.name);
					if(this.dayNumber > 0)
					{
						this.dayTitle.border = true;
					}

				
					//onDayOverURL = "javascript:document.getElementById('dateSpanID').innerHTML = '" + this.name + "';";
					/*this.onDayOverURL = new Object();
					this.onDayOverURL = "javascript:setText('dateSpanID', 'Over:"+this.name+"');";
					if (this._parent.thisObject.inHTML == true) {
						getURL(this.onDayOverURL);
					}*/
					
				};
				this[mvName].onPress = function() {
					this._parent.thisObject.myTrace("onPress: "+this.name);
					this._parent.selectedDay = this.dayNumber;
					//this.dayTitle.borderColor = 0xFF0000;

					if(this.dayNumber > 0)
					{
						this._parent.updateJS();
					}
					/*this.onDayPressURL = new Object();
					this.onDayPressURL = "javascript:setText('dateInputID', '" + this._parent.getStrDate() + "');";
					if (this._parent.thisObject.inHTML == true && this.dayNumber > 0) {
						getURL(this.onDayPressURL);
					}*/
				};
				this[mvName].dayTitle.selectable = false;
				this[mvName].dayTitle.embedFonts = false;
				this[mvName].dayTitle.setTextFormat(my_fmt);
			}
		}
	}
	private function drawDays(x:Number, y:Number, width:Number, height:Number):Void {
		this.myTrace("drawDays");
		this.drawRectangle(this, this.fillColor, this.lineColor, x, y, width, height);
		this.drawAlterRectangles(this, this.alternateFillColor, this.lineColor, x, y, width, height);
		this.drawDaysNames(x, y, width, height, 0);
	}
	private function drawContentBack(x:Number, y:Number, width:Number, height:Number):Void {
		this.myTrace("drawContentBack");
		//this.drawRectangle(this, this.fillColor, this.lineColor, x, y, width, height);
		//this.drawAlterRectangles(this, this.alternateFillColor, this.lineColor, x, y, width, height);
		var today_date:Date  = new Date();

		//var today_date:Date = new Date.UTC(tmp.);
		var given_date:Date = new Date(06, 06, 1);
		thisObject.myTrace(given_date.getUTCDay());
		this.drawDaysLines(x, y, width, height, 30, given_date.getUTCDay(), 31);
	}
	private function drawRectangle(mv:MovieClip, fillColor:Number, lineColor:Number, x:Number, y:Number, width:Number, height:Number):Void {
		this.myTrace("drawRectangle "+x+" : "+y+" - "+width+" : "+height);
		mv.beginFill(fillColor, 100);
		mv.lineStyle(1, lineColor, 100);
		mv.moveTo(x, y);
		mv.lineTo(width+x, y);
		mv.lineTo(width+x, height+y);
		mv.lineTo(x, height+y);
		mv.lineTo(x, y);
		mv.endFill();
	}
	private function drawInterLines(mv:MovieClip, fillColor:Number, lineColor:Number, x:Number, y:Number, width:Number, height:Number):Void {
		this.myTrace("drawInterLines");
		mv.lineStyle(1, lineColor, 100);
		var smallWidth = width/7;
		for (var i = 1; i<7; i++) {
			var currentX = i*smallWidth;
			mv.moveTo(currentX+x, y);
			mv.lineTo(currentX+x, height+y);
		}
	}
	private function drawAlterRectangles(mv:MovieClip, fillColor:Number, lineColor:Number, x, y, width, height):Void {
		this.myTrace("drawInterLines");
		mv.lineStyle(1, lineColor, 100);
		var smallWidth = width/7;
		for (var i = 1; i<7; i=i+2) {
			mv.beginFill(fillColor, 100);
			var currentX = i*smallWidth;
			mv.moveTo(currentX+x, y);
			mv.lineTo(currentX+x, height+y);
			mv.lineTo(currentX+smallWidth+x, height+y);
			mv.lineTo(currentX+smallWidth+x, y);
			mv.endFill();
		}
	}
	private function drawTriangle(mv:MovieClip, fillColor:Number, lineColor:Number, x, y, width, height):Void {
		this.myTrace("drawInterLines");
		mv.lineStyle(1, lineColor, 100);
		var smallWidth = width;
		mv.beginFill(fillColor, 100);
		mv.moveTo(x, y);
		mv.lineTo(x+width, height/2+y);
		mv.lineTo(x, height+y);
		mv.lineTo(x, y);
		mv.endFill();
	}
	private function myTrace(str:String):Void {
		if (this.debug == true) {
			trace(str);
			_root.debugTxt += str+"\n";
			_root.debugTxt.scroll = _root.debugTxt.maxscroll;
		}
	}
	
	static function main(mc) {
		cal = new Calendar();
		_root.attachMovie(
                     Calendar.symbolName, 
                    "CalendarInst",
                    _root.getNextHighestDepth());
		
	}

}
