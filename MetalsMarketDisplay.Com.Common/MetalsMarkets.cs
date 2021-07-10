using System;

namespace MetalsMarketDisplay.Com.Common
{
    public class MetalsMarkets
    {
        public bool MarketOpen { get; set; }
        public DateTimeOffset UpdateTime { get; set; }
        public Candle Silver { get; set; }
        public Candle Gold { get; set; }
        public Candle Platinum { get; set; }
        public Candle Palladium { get; set; }
    }
}
