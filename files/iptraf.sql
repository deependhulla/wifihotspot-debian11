
CREATE TABLE IF NOT EXISTS `ip_logs` (
  `id` int(11) NOT NULL,
  `day` varchar(55) NOT NULL,
  `month` varchar(55) NOT NULL,
  `date` varchar(55) NOT NULL,
  `hh` varchar(55) NOT NULL,
  `mm` varchar(55) NOT NULL,
  `ss` varchar(55) NOT NULL,
  `year` varchar(55) NOT NULL,
  `protocol` varchar(55) NOT NULL,
  `eth` varchar(55) NOT NULL,
  `num_bytes1` varchar(55) NOT NULL,
  `bytes1` varchar(55) NOT NULL,
  `froms` varchar(55) NOT NULL,
  `ip_from` varchar(55) NOT NULL,
  `port1` varchar(55) NOT NULL,
  `tos` varchar(55) NOT NULL,
  `ip_to` varchar(55) NOT NULL,
  `port2` varchar(55) NOT NULL,
  `f_packet` varchar(55) NOT NULL,
  `packets` varchar(55) NOT NULL,
  `num_pkt1` varchar(55) NOT NULL,
  `pkts1` varchar(55) NOT NULL,
  `num_bytes2` varchar(55) NOT NULL,
  `bytes2` varchar(55) NOT NULL,
  `avg1` varchar(55) NOT NULL,
  `flow1` varchar(55) NOT NULL,
  `rate1` varchar(55) NOT NULL,
  `num_kbits1` varchar(55) NOT NULL,
  `kbits1` varchar(55) NOT NULL,
  `opposites` varchar(55) NOT NULL,
  `directions` varchar(55) NOT NULL,
  `num_pkt2` varchar(55) NOT NULL,
  `pkts2` varchar(55) NOT NULL,
  `num_bytes3` varchar(55) NOT NULL,
  `bytes3` varchar(55) NOT NULL,
  `avg2` varchar(55) NOT NULL,
  `flow2` varchar(55) NOT NULL,
  `rate2` varchar(55) NOT NULL,
  `num_kbits2` varchar(55) NOT NULL,
  `kbits2` varchar(55) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

ALTER TABLE `ip_logs`
  ADD PRIMARY KEY (`id`),
  ADD KEY `day` (`day`),
  ADD KEY `month` (`month`),
  ADD KEY `date` (`date`),
  ADD KEY `hh` (`hh`),
  ADD KEY `mm` (`mm`),
  ADD KEY `ss` (`ss`),
  ADD KEY `year` (`year`),
  ADD KEY `ip_from` (`ip_from`),
  ADD KEY `ip_to` (`ip_to`),
  ADD KEY `port1` (`port1`),
  ADD KEY `port2` (`port2`),
  ADD KEY `num_kbits1` (`num_kbits1`),
  ADD KEY `kbits1` (`kbits1`),
  ADD KEY `rate1` (`rate1`),
  ADD KEY `num_bytes2` (`num_bytes2`),
  ADD KEY `bytes2` (`bytes2`),
  ADD KEY `f_packet` (`f_packet`),
  ADD KEY `packets` (`packets`);


ALTER TABLE `ip_logs`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
