using System;
using System.Collections.Generic;

namespace MetalsMarketDisplay.Com.Common
{
    public class MiscMarkets
    {
        public DateTimeOffset UpdateTime { get; set; }
        public List<MiscMarket> Market { get; set; }
    }
}
