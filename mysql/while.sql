-- 批量备份数据 按每5天的数据量进行备份
drop procedure if exists data_archive;
create PROCEDURE data_archive(in year_date int, in moon int)
BEGIN
    declare flag int default 1;
    set @tb_name = concat("StockLog_", year_date);
    set @sqlStr = concat("CREATE TABLE ", @tb_name, " LIKE StockLog;");
    PREPARE stmt from @sqlStr;EXECUTE stmt;DEALLOCATE PREPARE stmt;
    WHILE flag < moon + 1 DO
        set @date_1 = concat(year_date, "-", flag, "-", 1, " 00:00:00");
        set @date_5 = concat(year_date, "-", flag, "-", 5, " 00:00:00");
        set @date_10 = concat(year_date, "-", flag, "-", 10, " 00:00:00");
        set @date_15 = concat(year_date, "-", flag, "-", 15, " 00:00:00");
        set @date_20 = concat(year_date, "-", flag, "-", 20, " 00:00:00");
        set @date_25 = concat(year_date, "-", flag, "-", 20, " 00:00:00");
        IF flag = 12 then
            set @date_next = concat(year_date + 1, "-01-01 00:00:00");
		else
		    set @date_next = concat(year_date, "-", flag + 1, "-", 1, " 00:00:00");
        END IF;
        set @sql_1 = concat("INSERT INTO ", @tb_name, " SELECT * FROM StockLog WHERE created >= '", @date_1, "' AND created < '", @date_5, "'");
        set @sql_5 = concat("INSERT INTO ", @tb_name, " SELECT * FROM StockLog WHERE created >= '", @date_5, "' AND created < '", @date_10, "'");
        set @sql_10 = concat("INSERT INTO ", @tb_name, " SELECT * FROM StockLog WHERE created >= '", @date_10, "' AND created < '", @date_15, "'");
        set @sql_15 = concat("INSERT INTO ", @tb_name, " SELECT * FROM StockLog WHERE created >= '", @date_15, "' AND created < '", @date_20, "'");
        set @sql_20 = concat("INSERT INTO ", @tb_name, " SELECT * FROM StockLog WHERE created >= '", @date_20, "' AND created < '", @date_25, "'");
        set @sql_25 = concat("INSERT INTO ", @tb_name, " SELECT * FROM StockLog WHERE created >= '", @date_25, "' AND created < '", @date_next, "'");
        PREPARE stmt1 from @sql_1;EXECUTE stmt1;DEALLOCATE PREPARE stmt1;
        PREPARE stmt5 from @sql_5;EXECUTE stmt5;DEALLOCATE PREPARE stmt5;
        PREPARE stmt10 from @sql_10;EXECUTE stmt10;DEALLOCATE PREPARE stmt10;
        PREPARE stmt15 from @sql_15;EXECUTE stmt15;DEALLOCATE PREPARE stmt15;
        PREPARE stmt20 from @sql_20;EXECUTE stmt20;DEALLOCATE PREPARE stmt20;
        PREPARE stmt25 from @sql_25;EXECUTE stmt25;DEALLOCATE PREPARE stmt25;
        set flag = flag + 1;
    END WHILE;
END;

call data_archive(2017, 12);
call data_archive(2018, 12);
call data_archive(2019, 9);

-- 批量删除数据删除 按月分删除
drop procedure if exists data_delete;
create PROCEDURE data_delete(in year_date int, in moon int)
BEGIN
    declare flag int default 1;
    WHILE flag < moon + 1 DO
        IF flag = 12 then
            set @date_next = concat(year_date + 1, "-01-01 00:00:00");
		else
		    set @date_next = concat(year_date, "-", flag + 1, "-", 1, " 00:00:00");
        END IF;
        DELETE FROM StockLog WHERE created < @date_next;
        set flag = flag + 1;
    END WHILE;
END;
call data_delete(2017, 12);
call data_delete(2018, 12);
call data_delete(2019, 9);

