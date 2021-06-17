<?php
return [
    'use_sandbox' => true, // 是否使用沙盒模式

    'app_id' => '2021002131625945',
    'sign_type' => 'RSA2', // RSA  RSA2


    // 支付宝公钥字符串
    'ali_public_key' => 'MIIBIjANBgkqhkiG9w0BAQEFAAOCAQ8AMIIBCgKCAQEAzligRjztgpbCq370mjisDfDJ2seZk8bPcKcwjeDmARkknTi9AmN4kLbvgQ3a2eZD902+K+R38eW0k9h2b/oFpqLcE3lwaBSfjvPq7PXagtwZCm6yb8Y5SufjV/JTBPGc5NF+Kvwj+EQ5Eo/g97wPje8YP/PZlGvcW4hhGeOyI4bTFg6KGTTQoluk2Ve8GRT90wkMj/QaZ7CY53UccSNF+nk0t3FiTHxFAxb6lu6FDp9Kni0yK13N8DN+zp5Nq2EZNfZfqtYa13F+Mho772JKe7tXPk5pN3syfRl/SIAXJXOf6ZQIY83xT++FjNn8ph27R/m4a26vw9uLgsGlbTtn7QIDAQAB',

    // 自己生成的密钥字符串
    'rsa_private_key' => 'MIIEvwIBADANBgkqhkiG9w0BAQEFAASCBKkwggSlAgEAAoIBAQDOWKBGPO2ClsKrfvSaOKwN8Mnax5mTxs9wpzCN4OYBGSSdOL0CY3iQtu+BDdrZ5kP3Tb4r5Hfx5bST2HZv+gWmotwTeXBoFJ+O8+rs9dqC3BkKbrJvxjlK5+NX8lME8Zzk0X4q/CP4RDkSj+D3vA+N7xg/89mUa9xbiGEZ47IjhtMWDooZNNCiW6TZV7wZFP3TCQyP9BpnsJjndRxxI0X6eTS3cWJMfEUDFvqW7oUOn0qeLTIrXc3wM37Onk2rYRk19l+q1hrXcX4yGjvvYkp7u1c+Tmk3ezJ9GX9IgBclc5/plAhjzfFP74WM2fymHbtH+bhrbq/D24uCwaVtO2ftAgMBAAECggEAEJ1oQl+TjElRYXe2gFiB2hmCV2BtCE4g0+RSb4olWv9ISHSSG4gg5B4myNBxx8vXuykCYAxkcBDb6m+qkbejDtjcOaE0oNzQQDV5vBzLvG+2gHWLXp6qbFKhpqo3bxV5WZ9YtmNZDhuIMOtu5OO6qOYQoM2kvmO0+ZXQo8IGzP9gFfYOtGy/5af76Jr4sFGxWrEaz28KaNhpGKEy1FxaGiF7vadDfncrfiBZMrhZHCIoTzgtrZEiCrqzGzkMKtg/kP5pIj9DxqjzdiG+/7/DTR1KpJNFJv3uI+DhCSILjf5n+2ICQjNI9LrAdc3cE/iEqzenvtk76dZYSpmje26t4QKBgQD1dM2nWnuQN3HaK3pmDZU1wUyAVVJAaTQet2cAcB35Fcc/VhWhuZDtssXD52QRMTJd8Nf9PwkjTbY4EavBVqhlpjNsKjTBrwMJxpIkuxdE3qk4AKvwWWphx+6x18vr/s/eg5cUZSY3gSZuMxXraGVFP1hC6Y4c0H0XjC9QZxqFlQKBgQDXNb41oRvpBu9X3sVbUZTBNdsifo6NG4FhQBkySuV0KjvJ26hxdpq3KO7QkFIjT5xZIe7Zu3B7rm+akj/C0MvLnKq8v6DpGRD3KC+x1ntKEg3Q8rxXrBgJhmZ6GGhDBGRNalrLIxwyT9e7ljJj6hrQLr7oaKbbFczcab5UMh8S+QKBgQCzBpZY0a396fKoZb3IYW/K3Umm8JQlVpYlMS93Kk8yNag1kdwFMQt700BbOpHJ2FAcJGXk1+0aSrv0+S6EvWfle+tVoRMJkVRt9N7y22KFYMGbjyHZE957ow99tx+M6TVD3kZ7IatWIGSfS7NZF7OFZkZBx4dXjNkwK5b21byKYQKBgQC24zcnwChF2dzgYbJ6LlQp9aiqIb7m7679hEllUfy4wYNZwc/dzJsieCirGVqUI32Myad/ZSjsEotJYmvJFUN7X0JBcOA/90tRntcZXFod0kXngcDJCLjMr2i67a789OiAWZea9dVqdCuzgKqF+labAH7AZt8VY+tajIpwZr+9kQKBgQDZddqkCfQzRG4InglczKBTLg2vfroBgKglPFc0Tfadh/aD649gXkXpyJlx7qVnufI4emdM/qnwFbnMbDFDeQetEOu2+XXaKeU6PuJBBW1Bn3vw0p8h7Pd6WgzS3bIh6J08i1QlF7xxG3tTMB6CMQ8Ek2RmqgeAlXz/y6IqgCBPnA==',

    'limit_pay' => [
        //'balance',// 余额
        //'moneyFund',// 余额宝
        //'debitCardExpress',// 	借记卡快捷
        //'creditCard',//信用卡
        //'creditCardExpress',// 信用卡快捷
        //'creditCardCartoon',//信用卡卡通
        //'credit_group',// 信用支付类型（包含信用卡卡通、信用卡快捷、花呗、花呗分期）
    ], // 用户不可用指定渠道支付当有多个渠道时用“,”分隔

    // 与业务相关参数
    'notify_url' => 'https://dayutalk.cn/notify/ali',
    'return_url' => 'https://dayutalk.cn',

    'fee_type' => 'CNY', // 货币类型  当前仅支持该字段
];
