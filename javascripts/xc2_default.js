// date format
// -----------
xcDateFormat="yyyy-mm-dd";


// css conf
// --------
xcCSSPanel="panel";

xcCSSHeadBlock="row_head";
xcCSSHead="head";

xcCSSArrowMonthPrev=["arrow_prev", "arrow_prev_over", "arrow_prev_down"];
xcCSSArrowMonthNext=["arrow_next", "arrow_next_over", "arrow_next_down"];

xcCSSArrowYearPrev=["arrow_prev", "arrow_prev_over", "arrow_prev_down"];
xcCSSArrowYearNext=["arrow_next", "arrow_next_over", "arrow_next_down"];

xcCSSWeekdayBlock="row_week";
xcCSSWeekday="weekday";

xcCSSDayBlock="row_day";
xcCSSDay=["day", "day_over", "day_down", "day_disabled"];
xcCSSDayCurrent=["day_current", "", ""];
xcCSSDaySpecial=["day_special", "day_disabled"];
xcCSSDayEmpty="day_empty";

xcCSSFootBlock="row_foot";
xcCSSFootToday=["foot", "foot_over", "foot_down"];
xcCSSFootClear=["foot", "foot_over", "foot_down"];
xcCSSFootBack=["foot", "foot_over", "foot_down"];
xcCSSFootClose=["foot", "foot_over", "foot_down"];
xcCSSFootReset=["foot", "foot_over", "foot_down"];


// layout conf
// -----------
xcMonthNames=["Tháng Một", "Tháng Hai", "Tháng Ba", "Tháng Tư", "Tháng Năm", "Tháng Sáu", "Tháng Bảy", "Tháng Tám", "Tháng Chín", "Tháng Mười", "T. Mười Một", "T. Mười Hai"];
xcMonthShortNames=["T.1", "T.2", "T.3", "T.4", "T.5", "T.6", "T.7", "T.8", "T.9", "T.10", "T.11", "T.12"];
xcMonthPrefix="";
xcMonthSuffix="";

xcYearDigits=["0", "1", "2", "3", "4", "5", "6", "7", "8", "9"];
xcYearPrefix="";
xcYearSuffix="";

xcHeadSeparator=" - "; // separator string between year and month
xcHeadTagOrder=1; // 1: month/year, 0: year/month
xcHeadTagAdjustment=1; // 1: 100% width, 0: actual width

xcArrowMonth=["&#139;", "&#155;"];
xcArrowYear=["&#171;", "&#187;"];
xcArrowSwitch=[1, 1]; // [year, month] 1:on, 0:off
xcArrowPosition=0; // 0:in head block, 1:in foot block

// names for days
xcWeekdayNames=["Chủ Nhật", "Thứ Hai", "Thứ Ba", "Thứ Tư", "Thứ Năm", "Thứ Sáu", "Thứ Bảy", "Chủ Nhật"];
xcWeekdayShortNames=["C", "t2", "t3", "t4", "t5", "t6", "t7", "C"];
xcWeekdayDisplay=["C", "2", "3", "4", "5", "6", "7", "C"];

// foot links
xcFootTags=["Hôm nay", "Xóa", "Trở lại", "Đóng", "Reset", "_Today_", "_Back_", "_Reset_"];
xcFootTagSwitch=[1, 0, 0, 2, 0, 0, 0, 0]; // [today, clear, back, close, reset, _today_, _back_, _reset_] non-zero:display order, 0:off
xcFootTagAdjustment=0; // 1: % width, 0: actual width

// easy workaround for grid style
xcGridWidth=0; // used as cellspacing

// others
xcBaseZIndex=100; // z-index for calendar layers
xcMultiCalendar=0; // 1:multi-calendar, 0:single-calendar
xcShowCurrentDate=1; // 1:highlight current date/today, 0:no highlight
xcWeekStart=1; // 0:Sunday, 1:Monday
xcAutoHide=0; // 0: no auto hide, non-zero:auto hide interval in ms
xcStickyMode=0; // 0:non-sticky, 1:sticky

// day contents
xcDayContents=["&nbsp;", "1", "2", "3", "4", "5", "6", "7", "8", "9", "10", "11", "12", "13", "14", "15", "16", "17", "18", "19", "20", "21", "22", "23", "24", "25", "26", "27", "28", "29", "30", "31"];
xcDayContentsDisabled=xcDayContents;
xcDayContentsCurrent=xcDayContents;


// mod conf
// --------
xcModPath="../script/";
xcMods=[{"order": 0,  "mod": "Month/Year List",   "script": "mod_list.js"},
        {"order": 0,  "mod": "Date Range",        "script": "mod_date.js"},
        {"order": 0,  "mod": "Special Days",      "script": "mod_days.js"},
        {"order": 0,  "mod": "Date Info",         "script": "mod_info.js"},
        {"order": 0,  "mod": "Journal",           "script": "mod_journal.js"},
        {"order": 0,  "mod": "Date Link",         "script": "mod_link.js"},
        {"order": 0,  "mod": "Long Date Format",  "script": "mod_long.js"},
        {"order": 0,  "mod": "Tiles",             "script": "mod_tiles.js"},
        {"order": 0,  "mod": "Date Tips",         "script": "mod_tips.js"}];

// Month/Year List Mod
xcCSSMonthYearList="list";

xcMonthListFormat="Month"; // Month, MONTH, Mon, Mon, mm
xcYearListRange=5;
xcYearListPrevRange="&#171;&nbsp;";
xcYearListNextRange="&nbsp;&#187;"

// Date Link Mod & Journal Mod
xcLinkBasePath="";
xcLinkTargetWindow="_blank";
xcLinkTargetWindowPara="location=1,menubar=1,resizable=1,scrollbars=1,status=1,titlebar=1,toolbar=1";

// Journal Mod
xcLinkPrefix="";
xcLinkSuffix=".html";
xcLinkDateFormat="yyyymmdd";

// Date Tips Mod
xcDateTipTiming=1000;
xcDateTipBoxTitleSwitch=1; // 1: show title, 0:don't show
xcDateTipBoxPosition=6; // 0:date top, 3:date right, 6:date bottom, 9:date left
xcDateTipBoxAlign=1; // 0:left, 1:center, 2:right, for position of 0 and 6
xcDateTipBoxValign=0; // 0:top, 1:middle, 2:bottom, for position of 3 and 9
xcDateTipBoxOffsetX=0;
xcDateTipBoxOffsetY=6;
xcCSSDateTipBoxTitle="tip_title";
xcCSSDateTipBox="tip_box";

// Popup-Window Version
xcWindowWidth=215;
xcWindowHeight=195;
xcWindowTemplate="../script/xc2_template.html"
