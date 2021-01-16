--
-- データベース: `sample`
--

-- --------------------------------------------------------

--
-- テーブルの構造 `history`
--

CREATE TABLE `history` (
  `order_number` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `total_price` int(11) NOT NULL,
  `created` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- テーブルの構造 `details`
--

CREATE TABLE `details` (
  `detail_number` int(11) NOT NULL,
  `order_number` int(11) NOT NULL,
  `item_id` int(11) NOT NULL,
  `price` int(11) NOT NULL,
  `amount` int(11) NOT NULL,
  `created` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8;


--
-- テーブルのインデックス
--

--
-- テーブルのインデックス `history`
--
ALTER TABLE `history`
  ADD PRIMARY KEY (`order_number`);

ALTER TABLE `details`
  ADD PRIMARY KEY (`detail_number`);


--
-- テーブルのAUTO_INCREMENT `history`
--
ALTER TABLE `history`
  MODIFY `order_number` int(11) NOT NULL AUTO_INCREMENT;

ALTER TABLE `details`
  MODIFY `detail_number` int(11) NOT NULL AUTO_INCREMENT;




