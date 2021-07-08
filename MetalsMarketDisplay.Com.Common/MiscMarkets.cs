using System;
using System.Collections.Generic;

namespace MetalsMarketDisplay.Com.Common
{
    public class MiscMarkets
    {
        public DateTimeOffset UpdateTime { get; set; }
        public MiscCandle USD { get; set; }
        public MiscCandle DJIA { get; set; }
        public MiscCandle SPX { get; set; }
        public MiscCandle COMP { get; set; }
        public MiscCandle BTC { get; set; }
        public MiscCandle ETH { get; set; }
        public MiscCandle LTC { get; set; }
    }
}
