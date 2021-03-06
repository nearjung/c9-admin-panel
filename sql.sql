USE [C9Web]
GO
/****** Object:  Schema [Log]    Script Date: 01/05/2016 04:39:58 ******/
CREATE SCHEMA [Log] AUTHORIZATION [C9Web]
GO
/****** Object:  Schema [Web]    Script Date: 01/05/2016 04:39:58 ******/
CREATE SCHEMA [Web] AUTHORIZATION [dbo]
GO
/****** Object:  Table [Log].[TblLogin]    Script Date: 01/05/2016 04:39:43 ******/
SET ANSI_NULLS ON
GO
SET QUOTED_IDENTIFIER ON
GO
SET ANSI_PADDING ON
GO
CREATE TABLE [Log].[TblLogin](
	[id] [int] IDENTITY(1,1) NOT NULL,
	[pAccID] [varchar](32) NOT NULL,
	[pPwd] [varchar](32) NOT NULL,
	[pIp] [varchar](50) NOT NULL,
	[pIpCount] [int] NOT NULL,
	[pLastLogin] [datetime] NULL,
	[pLstLogin] [varchar](50) NULL
) ON [PRIMARY]
GO
SET ANSI_PADDING OFF
GO
SET IDENTITY_INSERT [Log].[TblLogin] ON
INSERT [Log].[TblLogin] ([id], [pAccID], [pPwd], [pIp], [pIpCount], [pLastLogin], [pLstLogin]) VALUES (1, N'master', N'123456', N'127.0.0.1', 0, CAST(0x0000A584004859A6 AS DateTime), N'1451942605')
SET IDENTITY_INSERT [Log].[TblLogin] OFF
/****** Object:  Table [Web].[TblLeftMenu]    Script Date: 01/05/2016 04:39:43 ******/
SET ANSI_NULLS ON
GO
SET QUOTED_IDENTIFIER ON
GO
CREATE TABLE [Web].[TblLeftMenu](
	[id] [int] IDENTITY(1,1) NOT NULL,
	[menu_catalog] [int] NOT NULL,
	[menu_name] [text] NOT NULL,
	[menu_link] [text] NOT NULL,
	[show] [int] NOT NULL
) ON [PRIMARY] TEXTIMAGE_ON [PRIMARY]
GO
SET IDENTITY_INSERT [Web].[TblLeftMenu] ON
INSERT [Web].[TblLeftMenu] ([id], [menu_catalog], [menu_name], [menu_link], [show]) VALUES (1, 1, N'Account Information', N'accountmanage', 1)
INSERT [Web].[TblLeftMenu] ([id], [menu_catalog], [menu_name], [menu_link], [show]) VALUES (2, 2, N'Game Management', N'gamemanage', 1)
INSERT [Web].[TblLeftMenu] ([id], [menu_catalog], [menu_name], [menu_link], [show]) VALUES (3, 3, N'Log Management', N'logmanage', 0)
INSERT [Web].[TblLeftMenu] ([id], [menu_catalog], [menu_name], [menu_link], [show]) VALUES (4, 4, N'Anylysis Management', N'analysismanage', 0)
INSERT [Web].[TblLeftMenu] ([id], [menu_catalog], [menu_name], [menu_link], [show]) VALUES (5, 5, N'System Management', N'systemmanage', 0)
INSERT [Web].[TblLeftMenu] ([id], [menu_catalog], [menu_name], [menu_link], [show]) VALUES (6, 1, N'Account Change', N'accountchange', 0)
INSERT [Web].[TblLeftMenu] ([id], [menu_catalog], [menu_name], [menu_link], [show]) VALUES (7, 1, N'Account Block', N'accountblock', 0)
INSERT [Web].[TblLeftMenu] ([id], [menu_catalog], [menu_name], [menu_link], [show]) VALUES (8, 1, N'Account Delete', N'accountdelete', 0)
INSERT [Web].[TblLeftMenu] ([id], [menu_catalog], [menu_name], [menu_link], [show]) VALUES (9, 1, N'Account Banned', N'accountban', 1)
INSERT [Web].[TblLeftMenu] ([id], [menu_catalog], [menu_name], [menu_link], [show]) VALUES (10, 1, N'Register Account', N'accountadd', 1)
INSERT [Web].[TblLeftMenu] ([id], [menu_catalog], [menu_name], [menu_link], [show]) VALUES (11, 1, N'Account unblock', N'accountunblock', 0)
INSERT [Web].[TblLeftMenu] ([id], [menu_catalog], [menu_name], [menu_link], [show]) VALUES (12, 5, N'Log out', N'logout', 0)
SET IDENTITY_INSERT [Web].[TblLeftMenu] OFF
/****** Object:  StoredProcedure [Web].[UspUpdateAccount]    Script Date: 01/05/2016 04:39:58 ******/
SET ANSI_NULLS ON
GO
SET QUOTED_IDENTIFIER ON
GO
-- =============================================
-- Author:		lmanso
-- Create date: 02/01/2016
-- Description:	Update Account
-- =============================================
CREATE PROCEDURE [Web].[UspUpdateAccount]
	-- Add the parameters for the stored procedure here
	@user_id INT,
	@username varchar(32),
	@password varchar(32),
	@auth INT,
	@hack VARCHAR(32),
	@mode INT
AS
BEGIN
	-- SET NOCOUNT ON added to prevent extra result sets from
	-- interfering with SELECT statements.
	SET NOCOUNT ON;
	DECLARE @aErrNo INT,
			@aRowCnt INT
			
		SELECT @aErrNo = 0, @aRowCnt = 0
	
    IF(@mode = 1)
    BEGIN
		UPDATE C9Unity.Auth.TblAccount SET cAccId = @username, cPassword = @password, cAuthLevel = @auth, cDetectedHack = @hack WHERE cAccNo = @user_id
	END
	
	ELSE IF(@mode = 2)
	BEGIN	
		IF EXISTS (SELECT * FROM C9Unity.Auth.TblAccountBlock WHERE cAccNo = @user_id)
		BEGIN
			UPDATE C9Unity.Auth.TblAccountBlock SET cDateEnd = @hack, cBlockReason = @auth WHERE cAccNo = @user_id
			UPDATE C9Unity.Auth.TblAccount SET cDetectedHack = '1' WHERE cAccNo = @user_id	
		END
		ELSE
		BEGIN
			INSERT INTO C9Unity.Auth.TblAccountBlock(cDateReg,cAccNo,cDateEnd,cDesc,cBlockReason,cBlockType) VALUES(GETDATE(),@user_id,@hack,'Banned',@auth,'1')
			UPDATE C9Unity.Auth.TblAccount SET cDetectedHack = '1' WHERE cAccNo = @user_id	
		END
	END
	
	ELSE IF(@mode = 3)
	BEGIN
		DELETE FROM C9Unity.Auth.TblAccount WHERE cAccNo = @user_id
		DELETE FROM C9Unity.Auth.TblAccountBlock WHERE cAccNo = @user_id
		INSERT INTO C9Unity.Auth.TblAccountDelete(cDateReg,cAccNo,cAccID) VALUES(GETDATE(),@user_id,@username)
	END
	
	ELSE IF(@mode = 4)
	BEGIN
		DELETE FROM C9Unity.Auth.TblAccountBlock WHERE cAccNo = @user_id
		UPDATE C9Unity.Auth.TblAccount SET cDetectedHack = 0 WHERE cAccNo = @user_id
	END
END
GO
/****** Object:  StoredProcedure [Log].[Login]    Script Date: 01/05/2016 04:39:58 ******/
SET ANSI_NULLS ON
GO
SET QUOTED_IDENTIFIER ON
GO
-- =============================================
-- Author:		lmanso
-- Create date: 02/01/2016
-- Description:	Log for login
-- =============================================
CREATE PROCEDURE [Log].[Login]
	-- Add the parameters for the stored procedure here
	@username varchar(32),
	@password varchar(32),
	@ip varchar(50),
	@BanTime INT,
	@FailedTime INT,
	@mode INT
AS
BEGIN
	SET NOCOUNT ON;

	DECLARE @aErrNo INT,
			@aRowCnt INT,
			@cCount INT,
			@cFaild INT,
			@cTimeStamp INT = (SELECT DATEDIFF(s, '19700101', GETDATE()))

	
	SELECT @aErrNo = 0, @aRowCnt = 0
	
	SELECT @cCount = pIpCount FROM [Log].[TblLogin] WHERE pIp = @ip
	SELECT @cFaild = pIpCount FROM [Log].[TblLogin] WHERE pIp = @ip
	
	IF(@mode = 1) -- OK
	BEGIN
		UPDATE [Log].[TblLogin] SET pAccID = @username, pPwd = @password, pIpCount = 0, pLstLogin = @BanTime, pLastLogin = GETDATE() WHERE pIp = @ip
	END
	ELSE IF(@mode = 2) -- WRONG
	BEGIN
		UPDATE [Log].[TblLogin] SET pAccID = @username, pPwd = @password, pIpCount = @cCount+1, pLstLogin = @BanTime, pLastLogin = GETDATE() WHERE pIp = @ip
	END
	ELSE IF(@mode = 3) -- Ban
	BEGIN
		UPDATE [Log].[TblLogin] SET pAccID = @username, pPwd = @password, pIpCount = 0, pLstLogin = @BanTime, pLastLogin = GETDATE() WHERE pIp = @ip
	END
	ELSE IF(@mode = 0) -- Do nothing
	BEGIN
		UPDATE [Log].[TblLogin] SET pAccID = @username, pPwd = @password, pLastLogin = GETDATE() WHERE pIp = @ip
	END
	
	SELECT @aErrNo = @@Error, @aRowCnt = @@RowCount
	IF (@aErrNo <> 0)
	BEGIN
		RETURN (1)
	END
		
	IF (@aRowCnt <> 1)
	BEGIN	
		INSERT INTO [Log].[TblLogin](pAccID,pPwd,pIp,pLstLogin,pLastLogin) VALUES(@username,@password,@ip,@cTimeStamp,GETDATE())
		SELECT @aErrNo = @@Error, @aRowCnt = @@RowCount
		IF (@aErrNo <> 0)
		BEGIN
			RETURN (1)
		END
	END
END
GO
/****** Object:  Default [DF_TblLogin_pIpCount]    Script Date: 01/05/2016 04:39:43 ******/
ALTER TABLE [Log].[TblLogin] ADD  CONSTRAINT [DF_TblLogin_pIpCount]  DEFAULT ((0)) FOR [pIpCount]
GO
/****** Object:  Default [DF_TblLeftMenu_show]    Script Date: 01/05/2016 04:39:43 ******/
ALTER TABLE [Web].[TblLeftMenu] ADD  CONSTRAINT [DF_TblLeftMenu_show]  DEFAULT ((1)) FOR [show]
GO
