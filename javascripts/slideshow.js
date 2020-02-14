img_delay=2000;
function set_speed(speed)
	{
	img_delay=speed
	//autoSlide()
	}
function CacheImage(ImageSource)
	{ // TURNS THE STRING INTO AN IMAGE OBJECT
	   var ImageObject = new Image();
	   ImageObject.src = ImageSource;
	   return ImageObject;
	}
function Show_home()
	{
	//document.Screen.src=Slides[0];
	document.images['Screen'].src = Slides[0].src;
	Message = 'Picture 1 of ' + Slides.length;
	self.defaultStatus = Message;
	CurrentSlide=0;
	}

function Slide()
	{
	if (is_auto==true)
		{
		if (NextSlide==Slides.length)
			CurrentSlide=-1;
		ShowSlide(1);
		window.setTimeout("Slide()", img_delay);
		}
	}

function autoSlide()
	{
	if (is_auto==false)
		{
		is_auto=true;
		document.auto.src='images/stop.gif';
		Slide();
		}
	else
		{
		is_auto=false;
		document.auto.src='images/play.gif';
		}
	}

function ShowSlide(Direction)
	{
	if (SlideReady==true)
	   	{
	    NextSlide = CurrentSlide + Direction;
	    if (NextSlide==Slides.length)
			{
			CurrentSlide=-1;
			// THIS WILL DISABLE THE BUTTONS (IE-ONLY)
	    	//document.SlideShow.Previous.disabled = (NextSlide == 0);
	    	//document.SlideShow.Next.disabled = (NextSlide == (Slides.length-1));    
	    	}
		if ((NextSlide >= 0) && (NextSlide < Slides.length) && document.images['Screen'])
			{
			//document.all.Screen.src = Slides[NextSlide].src;
			document.images['Screen'].src = Slides[NextSlide].src;
			CurrentSlide = NextSlide++;
			Message = 'Picture ' + (CurrentSlide+1) + ' of ' + Slides.length;
			self.defaultStatus = Message;
			if (Direction == 1)
				CacheNextSlide();
			}
	   return true;
	   }
	}

function Download()
	{
   	if (Slides[NextSlide].complete)
   		{
      	SlideReady = true;
      	self.defaultStatus = Message;
   		}
   	else setTimeout("Download()", 100); // CHECKS DOWNLOAD STATUS EVERY 100 MS
   	return true;
	}
function CacheNextSlide()
	{
   	if ((NextSlide < Slides.length) && (typeof Slides[NextSlide] == 'string'))
		{ // ONLY CACHES THE IMAGES ONCE
      	SlideReady = false;
      	self.defaultStatus = 'Downloading next picture...';
      	Slides[NextSlide] = CacheImage(Slides[NextSlide]);
      	Download();
   		}
   return true;
	}

function StartSlideShow()
	{
	CurrentSlide = -1;
	Slides[0] = CacheImage(Slides[0]);
	SlideReady = true;
	ShowSlide(1);
	}
function PreviewFile(source,width,height)
	{
	if (width>0 && height>0)
		{
		document.PREVIEWPIC.width=0
		document.PREVIEWPIC.height=0
		max=200
		if (width>max || height>max)
			{
			if (width>height)
				{
				ratio=height/width
				newwidth=max
				newheight=max*ratio
				}
			else
				{
				ratio=width/height
				newheight=max
				newwidth=max*ratio
				}
			}
		else
			{
			newwidth=width
			newheight=height
			}
		document.PREVIEWPIC.src=source
		document.PREVIEWPIC.width=newwidth
		document.PREVIEWPIC.height=newheight
		document.ImgFrm.ImageUrl.value=url
		document.ImgFrm.ImgSelectBtn.disabled=false
		}
	else
		document.PREVIEWPIC.src='../images/imgpreview.gif';
	}