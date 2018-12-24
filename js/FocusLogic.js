var FocusLogic = {};
(function (win, FocusLogic) {
    function Page() {
        this.areas = [];
        this.curAreaIndex = 0;
        this.move = function (direction) {
            var targets = this.areas[this.curAreaIndex].move(direction);	//值为undefined时表示焦点区域内移动,值为num时表示跨区域焦点移动反回下一�?区域在集合中的下�?,值为Array时表示将移动到指定区域的指定位置
            this.moveDirection(direction, targets); //方向�?事件
            if (targets != undefined) {
                var tmpNextArea;
                if (_isArray(targets)) {
                    tmpNextArea = targets[0];
                    this.areas[tmpNextArea].curDomIndex = targets[1] >= this.areas[tmpNextArea].domsCount ? (this.areas[tmpNextArea].domsCount - 1) : targets[1];
                } else {
                    tmpNextArea = targets;
                    if (this.curAreaIndex != this.areas[tmpNextArea].childAreaIndex[this.curAreaIndex]) {
                        this.areas[tmpNextArea].curDomIndex = 0;
                    }
                }
                if (this.areas[tmpNextArea].domsCount <= 0) return;
                this.setCurrentFocus(tmpNextArea, "", direction);
            }
        };

        this.pageTurn = function (num) {
            this.areas[this.curAreaIndex].pageTurn(num, this.curAreaIndex);
        };

        this.okEvent = undefined;	//点击�?定键执�?�的function,如果当前区域没有定义ok事件则执行当前页的ok事件
        this.ok = function () {
            if ((!!this.areas[this.curAreaIndex].ok()) && this.okEvent != undefined) {
                this.okEvent();
            }
        };

        this.backEvent = undefined;	//点击返回�?执�?�的function,如果当前区域没有定义返回事件则执行当前页的返回事�?
        this.back = function () {
            if ((!!this.areas[this.curAreaIndex].back()) && this.backEvent != undefined) {
                this.backEvent();
            }
        };

        this.moveDirectionEvent = undefined;		//方向�?事件0�?1�?2�?3   上下左右
        this.moveDirection = function (direction, targets) {
            if ((!!this.areas[this.curAreaIndex].moveDirection(direction, targets)) && this.moveDirectionEvent != undefined) {
                return this.moveDirectionEvent(direction, targets);
            }
        };

        this.numInputEvent = undefined;	//输入数字执�?�的function,如果当前区域没有定义数字输入事件则执行当前页的数字输入事�?
        this.numInput = function (num) {
            if ((!!this.areas[this.curAreaIndex].numInput(num)) && this.numInputEvent != undefined) {
                this.numInputEvent(num);
            }
        };

        this.setCurrentFocus = function (_curAreaIndex, _curDomIndex, direction) {
            var flag = true;
            if (this.curAreaIndex != _curAreaIndex) {
                this.clearFocus(this.curAreaIndex, this.areas[this.curAreaIndex].curDomIndex);
                this.areas[_curAreaIndex].preAreaIndex = this.curAreaIndex;
                this.areas[this.curAreaIndex].objFocusHidden();
                if (this.areas[this.curAreaIndex].areaOutEvent != undefined) {
                    this.areas[this.curAreaIndex].areaOutEvent();
                }
                this.curAreaIndex = _curAreaIndex;
                this.areas[this.curAreaIndex].objFocusVisible();
                flag = false;
            }

            if (_curDomIndex != undefined) {
                this.areas[this.curAreaIndex].objFocusVisible(_curDomIndex);
                this.areas[_curAreaIndex].setCurrentFocus(_curDomIndex, "appoint", direction);
            } else {
                if (!!flag) {
                    this.areas[_curAreaIndex].setCurrentFocus("", "inside", direction);
                } else {
                    this.areas[_curAreaIndex].setCurrentFocus("", "cross", direction);
                }
            }
        };

        this.clearFocus = function (_curAreaIndex, _curDomIndex) {
            this.areas[_curAreaIndex].clearFocus(_curDomIndex);
        };

        //设置栏目和节�?的区域关�?
        this.setAreaMembership = function (parentAreaId, childAreaId) {
            this.areas[parentAreaId].childAreaIndex[childAreaId] = childAreaId;
            this.areas[childAreaId].parentAreaIndex = parentAreaId;
        };
    }

    function Area(row, colum, doms, areaDirections, curDomIndex, turnDirection) {
        this.row = row;
        this.colum = colum;
        this.doms = doms;
        this.areaDirections = areaDirections;	//区域之间的移动�?�则,定义上左下右移动逻辑的数�?
        this.curIndex = undefined;	//当前区域在page.areas数组�?的下�?
        this.curDomIndex = curDomIndex == undefined ? 0 : curDomIndex;	//区域内默认焦�?
        this.preDomIndex = this.curDomIndex;	//当前焦点的上一�?焦点
        this.childAreaIndex = [];	//当前区域如果�?栏目,则�?�值表示当前栏�?下的内�?�所在的区域
        this.parentAreaIndex = undefined;	//当前区域的父栏目区域
        this.preAreaIndex = undefined;	//焦点移动到当前区域之前的区域的index
        this.domsMaxLength = this.row * this.colum;	//区域内最多能加载dom的个�?
        this.objFocus = undefined;	//设置焦点移动的滑动效果["menu_top_focus",[20,125],[101,0],10)]�?参数分别表示焦点框id,�?向平移的各项属�?[每�?�移动�?�长,初�?�left属性值],纵向移动的各项属�?[步长，初始top值],移动到下�?焦点的总时�?
        this.domNavId = undefined;

        this.dataCount = undefined;	//区域内需要载入的数据的总个�?
        this.domsCount = this.row * this.colum;	//区域内dom元素的数�?,对于翻页造成区域内dom元素少于row*colum的情况，需要重新赋�?
        this.pageNumber = 1;		//当前区域所展示的页�?
        this.pageTotal = undefined;	//区域总页�?

        //封�?�文字跑�?�?效果参数
        this.dataList = undefined;
        this.normalTxtAttr = undefined;
        this.cutTxtAttr = undefined;
        this.domTxtId = undefined;
        this.listFlag = undefined;	//dataList�?否是取的全部数据1表示�?�?0表示取的当页数据

        this.areaOutEvent = undefined;	//焦点移出区域执�?��?�事�?
        this.focusEvent = undefined;	//区域中dom元素获得焦点时执行�?�事�?
        this.pageTurnEvent = undefined;	//翻页事件,焦点逻辑处理完之后调�?
        this.turnDirection = turnDirection;//�?定义翻页事件方向�?0为上下，1为左�?,-1为�?��?�方向键翻页,
        this.pageTurn = function (num, _curAreaIndex) {
            if (this.pageTotal == undefined || this.pageTotal <= 1) return;
            this.preDomIndex = this.curDomIndex;
            if (num != undefined) {
                if (typeof (num) == "string") {
                    this.pageNumber = parseInt(num);
                } else {
                    this.pageNumber = this.pageNumber + num;
                    if (this.pageNumber > this.pageTotal) {
                        this.pageNumber = 1;
                    } else if (this.pageNumber <= 0) {
                        this.pageNumber = this.pageTotal;
                    }
                }
            }

            this.domsCount = this.pageTotal == this.pageNumber ? ((this.dataCount - 1) % (this.domsMaxLength) + 1) : this.domsMaxLength;

            this.curDomIndex = this.curDomIndex >= this.domsCount ? (this.domsCount - 1) : (_curAreaIndex != undefined && _curAreaIndex == this.curIndex ? 0 : this.curDomIndex);//为实现页�?pageTurnEvent方法实时获取curDomIndex

            if (this.pageTurnEvent != undefined) {
                this.pageTurnEvent();
            }

            this.setDomsTxt();
            if (_curAreaIndex != undefined && _curAreaIndex == this.curIndex) {
                this.clearFocus(this.preDomIndex);//为防止采用翻页键翻页，页�?之前的焦点无法清除的�?题；
                this.setCurrentFocus(0, "pageTurn");
            }

            this.refreshDom();
        };

        this.move = function (direction) {
            var targets = this.doms[this.curDomIndex].move(direction);
            if (targets != undefined && _isArray(targets)) {
                if (targets.length == 1) {
                    if (this.areaDirections[direction] != -1) {
                        targets.unshift(this.areaDirections[direction]);
                    } else {
                        targets.unshift(this.curIndex);
                    }
                }
                if (this.curIndex == targets[0]) {
                    this.clearFocus(this.curDomIndex);
                }
                return targets;
            }
            var dir = direction % 2;	//等于0为纵向移�?，等�?1为横向移�?;
            var step = dir == direction ? -1 : 1;	//移动步伐�?-1向左者向上，1向右或向�?
            var cross;	//判断焦点�?否�?�移动至下一�?区域,true(移至下一�?区域),false(区域内移�?);
            //计算cross的�?
            if (dir == 0) {
                if (step == 1) {
                    if (this.domsCount) {
                        cross = (this.curDomIndex + 1 + step * this.colum) > this.domsCount;
                    } else {
                        cross = (this.curDomIndex + 1 + step * this.colum) > this.domsMaxLength;
                    }
                } else {
                    cross = (this.curDomIndex + step * this.colum) < 0;
                }
            } else {
                if (step == 1) {
                    if (this.domsCount) {
                        cross = (this.curDomIndex + step >= this.domsCount) || (this.curDomIndex % this.colum == (this.colum - 1));
                    } else {
                        cross = this.curDomIndex % this.colum == (this.colum - 1);
                    }
                } else {
                    cross = this.curDomIndex % this.colum == 0;
                }
            }

            if (!cross) {
                var tmpDomIndex = this.curDomIndex;
                if (dir == 0) {
                    this.curDomIndex = this.curDomIndex + step * this.colum;
                } else {
                    this.curDomIndex = this.curDomIndex + step;
                }
                this.clearFocus(tmpDomIndex);
                this.setCurrentFocus("", "inside", direction);
            } else {
                if (this.areaDirections[direction] != -1) {
                    return this.areaDirections[direction];
                } else {
                    if (this.dataCount != undefined) {
                        var tmpDomIndex = this.curDomIndex;
                        var _row = Math.ceil(this.domsCount / this.colum);	//得到当前数据�?充的行数
                        if ((_row <= 1 && dir == 0 && this.pageTotal == 1) || (this.colum == 1 && dir == 1) || (this.domsCount == 1 && this.pageTotal == 1) || this.turnDirection != undefined && this.pageTotal == 1) return;
                        if (dir == 0) {
                            if (this.row == 1 || this.turnDirection != undefined && this.turnDirection) return;
                            if (step == 1) {
                                if (this.pageTotal == 1) {
                                    if (Math.ceil((this.curDomIndex + 1) / this.colum) < _row) {
                                        this.curDomIndex = this.curDomIndex % this.colum + (this.row - 1) * this.colum;
                                    } else {
                                        this.curDomIndex = this.curDomIndex % this.colum;
                                    }
                                    this.pageNumber = 1;
                                } else {
                                    this.curDomIndex = this.curDomIndex % this.colum;
                                    this.pageNumber = this.pageNumber == this.pageTotal ? 1 : (this.pageNumber + step);
                                }
                            } else {
                                if (this.pageNumber == 1) {
                                    if (this.pageTotal == 1) {
                                        this.curDomIndex = this.curDomIndex % this.colum + (this.row - 1) * this.colum;
                                    } else {
                                        this.curDomIndex = (this.dataCount - 1) % (this.domsMaxLength);
                                    }
                                    this.pageNumber = this.pageTotal;
                                } else {
                                    this.curDomIndex = this.curDomIndex % this.colum + (this.row - 1) * this.colum;
                                    this.pageNumber = this.pageNumber + step;
                                }
                            }
                        } else {
                            if (this.turnDirection != undefined && !this.turnDirection || this.turnDirection == -1) {
                                return;
                            } else if (this.turnDirection) {
                                if (step == 1) {
                                    if (this.pageTotal == 1) {
                                        if (Math.ceil((this.curDomIndex + 1) / this.colum) < _row) {
                                            this.curDomIndex = this.curDomIndex % this.colum + (this.row - 1) * this.colum;
                                        } else {
                                            this.curDomIndex = this.curDomIndex % this.colum;
                                        }
                                        this.pageNumber = 1;
                                    } else {
                                        this.curDomIndex = this.curDomIndex % this.colum == (this.colum - 1) ? this.curDomIndex : 0;
                                        this.pageNumber = this.pageNumber == this.pageTotal ? 1 : (this.pageNumber + step);
                                    }
                                } else {
                                    if (this.pageNumber == 1) {
                                        if (this.pageTotal == 1) {
                                            this.curDomIndex = this.curDomIndex % this.colum + (this.row - 1) * this.colum;
                                        } else {
                                            this.curDomIndex = (this.dataCount - 1) % (this.domsMaxLength);
                                        }
                                        this.pageNumber = this.pageTotal;
                                    } else {
                                        // this.curDomIndex = this.curDomIndex % this.colum + (this.row - 1) * this.colum;
                                        this.pageNumber = this.pageNumber + step;
                                    }
                                }
                            } else {
                                this.curDomIndex = this.curDomIndex + step;
                                if (this.curDomIndex >= this.domsCount) {
                                    this.curDomIndex = 0;
                                    this.pageNumber = this.pageNumber == this.pageTotal ? 1 : (this.pageNumber + step);
                                } else if (this.curDomIndex < 0) {
                                    if (this.pageNumber == 1) {
                                        this.curDomIndex = (this.dataCount - 1) % (this.domsMaxLength);
                                        this.pageNumber = this.pageTotal;
                                    } else {
                                        this.curDomIndex = this.domsMaxLength - 1;
                                        this.pageNumber = this.pageNumber + step;
                                    }
                                }
                            }

                        }
                        this.pageTurn();
                        this.curDomIndex = this.curDomIndex >= this.domsCount ? (this.domsCount - 1) : this.curDomIndex;
                        this.clearFocus(tmpDomIndex);
                        this.setCurrentFocus("", "circle", direction);
                    }
                }
            }
        };

        this.okEvent = undefined;	//如果当前焦点没有定义ok事件，则执�?��?�区域的ok事件
        this.ok = function () {
            if (!!this.doms[this.curDomIndex].ok()) {
                if (this.okEvent != undefined) {
                    return this.okEvent();
                } else {
                    return true;
                }
            } else {
                return false;
            }
        };

        this.backEvent = undefined;	//如果当前焦点没有定义返回事件，则执�?��?�区域的返回事件
        this.back = function () {
            if (!!this.doms[this.curDomIndex].back()) {
                if (this.backEvent != undefined) {
                    return this.backEvent();
                } else {
                    return true;
                }
            } else {
                return false;
            }
        };

        this.moveDirectionEvent = undefined;		//方向�?事件0�?1�?2�?3   上下左右
        this.moveDirection = function (direction, targets) {
            if (!!this.doms[this.curDomIndex].moveDirection(direction, targets)) {
                if (this.moveDirectionEvent != undefined) {
                    this.moveDirectionEvent(direction, targets);
                } else {
                    return true;
                }
            } else {
                return false;
            }
        };

        this.numInputEvent = undefined;	//输入数字执�?�的function,如果当前焦点没有定义数字输入事件则执行当前区域的数字输入事件
        this.numInput = function (num) {
            if (!!this.doms[this.curDomIndex].numInput(num)) {
                if (this.numInputEvent != undefined) {
                    return this.numInputEvent(num);
                } else {
                    return true;
                }
            } else {
                return false;
            }
        };

        this.setCurrentFocus = function (_curDomIndex, _type, direction) {
            if (_curDomIndex !== "") {
                this.clearFocus(this.curDomIndex);
                this.curDomIndex = _curDomIndex;
            }
            this.doms[this.curDomIndex].changeStyle(true, this.objFocus);

            if (!!this.doms[this.curDomIndex]._focus()) {
                if (this.focusEvent != undefined) {
                    this.focusEvent(_type, direction);		//_type有五�?�?"appoint"表示page对象调用setCurrentFocus方法指定焦点移动到某�?点的情况,"cross"表示焦点跨区域移动的情况,"pageTurn"表示翻页时的焦点移动,"inside"表示区域内的焦点移动的情�?,"circle"表示区域内焦点的�?�?移动的情�?(例�??1�?3列的区域�?,焦点�?0号位�?再向上移动焦点会移动�?2号位�?)
                }
            }
        };

        this.clearFocus = function (_curDomIndex) {
            this.preDomIndex = _curDomIndex;
            this.doms[_curDomIndex].changeStyle(false);
        };

        this.setDataCount = function (num, domNavId) {
            this.dataCount = num;
            this.domsMaxLength = this.colum * this.row;
            this.pageTotal = Math.ceil(this.dataCount / (this.colum * this.row));
            if (this.pageTotal == 0) {
                this.domsCount = 0;
                this.pageTotal = 1;
            } else {
                this.domsCount = this.pageTotal == this.pageNumber ? ((this.dataCount - 1) % (this.domsMaxLength) + 1) : this.domsMaxLength;
            }
            if (domNavId != undefined) {
                this.domNavId = domNavId;
            }
            this.refreshDom();
        };

        this.refreshDom = function () {
            for (var i = 0; i < this.domsMaxLength; i++) {
                var _element;
                if (this.domNavId != undefined) {
                    _element = getIframeWinID(this.domNavId + i);
                } else {
                    _element = this.doms[i].element;
                }
                if (_element != undefined && _element != "" && _element != null && _element != "null") {
                    try {
                        if (this.domsCount > i) {
                            _element.style.visibility = "visible";
                        } else {
                            _element.style.visibility = "hidden";
                        }
                    } catch (e) {
                        console.log("refreshDom---this.domsCount:" + this.domsCount + "--i:" + i);
                    }
                }
            }
        };

        this.objFocusHidden = function () {
            if (this.objFocus != undefined) {
                getIframeWinID(this.objFocus[0]).style.visibility = "hidden";
            }
        };

        this.objFocusVisible = function (_curDomIndex) {
            var tempDomIndex = _curDomIndex == undefined ? this.curDomIndex : _curDomIndex;
            if (this.objFocus != undefined) {
                getIframeWinID(this.objFocus[0]).style.left = (parseInt(this.doms[tempDomIndex].element.style.left) + (this.objFocus[1][1] == undefined ? 0 : this.objFocus[1][1])) + "px";
                getIframeWinID(this.objFocus[0]).style.top = (parseInt(this.doms[tempDomIndex].element.style.top) + (this.objFocus[2][1] == undefined ? 0 : this.objFocus[2][1])) + "px";
                getIframeWinID(this.objFocus[0]).style.visibility = "visible";
            }
        };

        this.setAttrForDomsTxt = function (dataList, normalTxtAttr, cutTxtAttr, listFlag, domTxtId) {
            this.dataList = dataList;
            this.normalTxtAttr = normalTxtAttr;
            if (_isArray(cutTxtAttr)) {
                this.cutTxtAttr = cutTxtAttr[0];
                this.addCutTxtAttr(cutTxtAttr[1]);
            } else {
                this.cutTxtAttr = cutTxtAttr;
            }

            this.listFlag = listFlag;
            this.domTxtId = domTxtId;
            this.setDomsTxt(false);
        };

        this.addCutTxtAttr = function (len) {
            for (var i = 0; i < this.dataList.length; i++) {
                var txtlen = this.dataList[i][this.normalTxtAttr].length;
                this.dataList[i][this.cutTxtAttr] = txtlen <= len ? this.dataList[i][this.normalTxtAttr] : this.dataList[i][this.normalTxtAttr].slice(0, len) + "...";
            }
        };

        this.setDomsTxt = function (first_in) {
            if (this.listFlag != undefined) {
                var _offset = (this.pageNumber - 1) * this.domsMaxLength * this.listFlag;
                for (var i = 0; i < this.domsMaxLength; i++) {
                    try {
                        if (i < this.domsCount) {
                            if (this.normalTxtAttr == -1 || this.cutTxtAttr == -1) {
                                this.doms[i].normalTxt = this.dataList[0][i + _offset];
                                this.doms[i].cutTxt = this.dataList[1][i + _offset];
                            } else {
                                this.doms[i].normalTxt = this.dataList[i + _offset][this.normalTxtAttr];
                                this.doms[i].cutTxt = this.dataList[i + _offset][this.cutTxtAttr];
                            }
                            if (this.domTxtId != undefined) {
                                this.doms[i].domTxtId = this.domTxtId + i;
                            }
                            if (!first_in) {
                                getIframeWinID(this.doms[i].domTxtId).innerHTML = this.doms[i].cutTxt;
                            }
                        } else {
                            this.doms[i].normalTxt = undefined;
                            this.doms[i].cutTxt = undefined;
                        }
                    } catch (e) {
                        console.log("setDomsTxt---dataList:" + this.dataList);
                        console.log("_offset:" + _offset + "--i:" + i + "--this.pageNumber:" + this.pageNumber);
                        console.log(e.message + ":" + e.name);
                    }
                }
            }
        };

        this.setMarqueeWidth = function (_width) {
            for (var i = 0; i < this.domsMaxLength; i++) {
                this.doms[i].marquee = _width + "px";
            }
        }
    }

    function Dom(domId, focusClassName, blurClassName) {
        this.domId = domId;
        this.focusClassName = focusClassName;
        this.blurClassName = blurClassName;
        this.curIndex = undefined;
        this.moveRule = undefined;	//单独定义�?dom的移动�?�则，以数组的形式表�?,如[-1,-1,[3],[1,4]]按[�?,�?,�?,右]的顺序分�?定义各个方向的目标焦�?,-1表示按初始逻辑移动焦点,[3]�?3表示下个区域的domIndex,下个区域的index的值由初�?�定义�?;[1,4]�?1表示下个区域的index,4表示下个区域的domIndex;
        this.element = getIframeWinID(this.domId);

        //处理文字跑马�?效果参数
        this.domTxtId = domId;
        this.cutTxt = undefined;
        this.normalTxt = undefined;
        this.marquee = "auto";

        this.t_x = "";
        this.t_y = "";

        this.move = function (direction) {
            if (this.moveRule != undefined && _isArray(this.moveRule) && this.moveRule[direction] != -1) {
                return this.moveRule[direction];
            }
        };

        this.okEvent = undefined;	//焦点点击事件
        this.ok = function () {
            if (this.okEvent != undefined) {
                return this.okEvent();
            } else {
                return true;
            }
        };

        this.backEvent = undefined;	//返回事件
        this.back = function () {
            if (this.backEvent != undefined) {
                return this.backEvent();
            } else {
                return true;
            }
        };

        this.moveDirectionEvent = undefined;		//方向�?事件0�?1�?2�?3   上下左右
        this.moveDirection = function (direction, targets) {
            if (this.moveDirectionEvent != undefined) {
                this.moveDirectionEvent(direction, targets);
            } else {
                return true;
            }
            ;
        };

        this.numInputEvent = undefined;	//输入数字执�?�的function
        this.numInput = function (num) {
            if (this.numInputEvent != undefined) {
                return this.numInputEvent(num);
            } else {
                return true;
            }
        };

        this.focusEvent = undefined;	//当前dom元素获得焦点后执行�?�事�?
        this._focus = function () {
            if (this.focusEvent != undefined) {
                return this.focusEvent();
            } else {
                return true;
            }
        };

        this.changeStyle = function (focusFlag, _objFocus) {
            if (focusFlag) {
                if (_objFocus != undefined) {
                    this.slithier(_objFocus);
                }
                if (this.focusClassName != "" && this.focusClassName != undefined) {
                    this.element.className = this.focusClassName;
                }
                if (this.normalTxt != undefined && this.normalTxt != this.cutTxt) {
                    getIframeWinID(this.domTxtId).innerHTML = "<marquee width='" + this.marquee + "'>" + this.normalTxt + "</marquee>";
                }
            } else {
                if (this.blurClassName != "" && this.blurClassName != undefined) {
                    this.element.className = this.blurClassName;
                }
                if (this.cutTxt != undefined) {
                    getIframeWinID(this.domTxtId).innerHTML = this.cutTxt;
                }
            }
        };

        //滑动效果
        this.slithier = function (_objFocus) {
            var _domStyle;
            if (_isArray(_objFocus[0])) {
                _domStyle = getIframeWinID(_objFocus[0][1]).style;
            } else {
                _domStyle = this.element.style;
            }
            ;
            //x轴参�?
            var step_x = _objFocus[1] == undefined ? 1 : (_objFocus[1][0] == undefined ? 1 : _objFocus[1][0]);
            var targetLeft = parseInt(_domStyle.left == "" ? "0" : _domStyle.left) + (_objFocus[1][1] == undefined ? 0 : _objFocus[1][1]);
            var curLeft = parseInt(getIframeWinID(_objFocus[0]).style.left);
            //y轴参�?
            var step_y = _objFocus[2] == undefined ? 1 : (_objFocus[2][0] == undefined ? 1 : _objFocus[2][0]);
            var targetTop = parseInt(_domStyle.top == "" ? "0" : _domStyle.top) + (_objFocus[2][1] == undefined ? 0 : _objFocus[2][1]);
            var curTop = parseInt(getIframeWinID(_objFocus[0]).style.top);

            var time_x = undefined;
            var time_y = undefined;
            if (targetLeft != curLeft) {
                time_x = Math.round(_objFocus[3] / (Math.abs(targetLeft - curLeft) / step_x));
                slithierMove_x();
            }
            if (targetTop != curTop) {
                time_y = Math.round(_objFocus[3] / (Math.abs(targetTop - curTop) / step_y));
                slithierMove_y();
            }

            function slithierMove_x() {
                if (step_x == 0 && _objFocus[3] != 0) return;
                var leftDir = targetLeft > curLeft ? 1 : -1;
                curLeft += leftDir * step_x;
                if ((curLeft >= targetLeft && leftDir == 1) || (curLeft <= targetLeft && leftDir == -1) || _objFocus[3] == 0) {
                    curLeft = targetLeft;
                } else {
                    clearTimeout(this.t_x);
                    this.t_x = setTimeout(slithierMove_x, time_x);
                }
                getIframeWinID(_objFocus[0]).style.left = curLeft + "px";
            };

            function slithierMove_y() {
                if (step_y == 0 && _objFocus[3] != 0) return;
                var topDir = targetTop > curTop ? 1 : -1;
                curTop += topDir * step_y;
                if ((curTop >= targetTop && topDir == 1) || (curTop <= targetTop && topDir == -1) || _objFocus[3] == 0) {
                    curTop = targetTop;
                } else {
                    clearTimeout(this.t_y);
                    this.t_y = setTimeout(slithierMove_y, time_y);
                }
                getIframeWinID(_objFocus[0]).style.top = curTop + "px";
            }
        }
    };

    function loadElements(row, colum, domId, focusClassName, blurClassName, areaDirections, curDomIndex, turnDirection) {
        var tmpDoms = [];
        for (var i = 0; i < row * colum; i++) {
            var tmpDom = new Dom(domId + i, focusClassName, blurClassName);
            tmpDom.curIndex = i;
            tmpDoms.push(tmpDom);
        }
        var tmpArea = new Area(row, colum, tmpDoms, areaDirections, curDomIndex, turnDirection);
        tmpArea.curIndex = FocusLogic.page.areas.length;
        FocusLogic.page.areas.push(tmpArea);
        return tmpArea;
    }

    function _isArray(o) {
        return Object.prototype.toString.call(o) === '[object Array]';
    }


    function getIframeWinID(id) {
        return iframeWindow().document.getElementById(id);
    }

    function iframeWindow() {
        return document.getElementById("EPG").contentWindow;
    }

    win.initFocusLogic = function() {
        FocusLogic.page = new Page();
    };

    FocusLogic.loadElements = loadElements;

})(window, FocusLogic);
