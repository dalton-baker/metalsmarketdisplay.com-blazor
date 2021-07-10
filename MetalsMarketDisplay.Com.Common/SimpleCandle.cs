using System;

namespace MetalsMarketDisplay.Com.Common
{
    public class SimpleCandle
    {
        public DateTimeOffset UpdateTime { get; set; }
        public double Ask { get; set; }
        public double Bid { get; set; }
    }
}
