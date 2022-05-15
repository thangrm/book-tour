<?php

return [

    /*
    |--------------------------------------------------------------------------
    | Validation Language Lines
    |--------------------------------------------------------------------------
    |
    | Trường following language lines contain the default error messages used by
    | the validator class. Some of these rules have multiple versions such
    | as the size rules. Feel free to tweak each of these messages here.
    |
    */

    'accepted' => 'Trường :attribute phải được chấp nhận.',
    'active_url' => 'Trường :attribute không phải là một URL hợp lệ.',
    'after' => 'Trường :attribute phải là một ngày sau :date.',
    'after_or_equal' => 'Trường :attribute phải là một ngày sau hoặc bằng :date.',
    'alpha' => 'Trường :attribute chỉ được chứa các chữ cái.',
    'alpha_dash' => 'Trường :attribute chỉ được chứa các chữ cái, số, dấu gạch ngang và dấu gạch dưới.',
    'alpha_num' => 'Trường :attribute chỉ được chứa các chữ cái và số.',
    'array' => 'Trường :attribute phải là một mảng.',
    'before' => 'Trường :attribute phải là một ngày trước :date.',
    'before_or_equal' => 'Trường :attribute phải là một ngày trước hoặc bằng :date.',
    'between' => [
        'numeric' => 'Trường :attribute phải ở giữa :min và :max.',
        'file' => 'Trường :attribute phải ở giữa :min và :max kilobytes.',
        'string' => 'Trường :attribute phải ở giữa :min và :max kí tự.',
        'array' => 'Trường :attribute phải ở giữa :min và :max phần tử.',
    ],
    'boolean' => 'Trường :attribute phải đúng hoặc sai.',
    'confirmed' => 'Trường :attribute xác nhận không phù hợp.',
    'date' => 'Trường :attribute không phải là ngày hợp lệ.',
    'date_equals' => 'Trường :attribute phải là một ngày bằng :date.',
    'date_format' => 'Trường :attribute không phù hợp với định dạng :format.',
    'different' => 'Trường :attribute và :other phải khác.',
    'digits' => 'Trường :attribute cần phải :digits chữ số.',
    'digits_between' => 'Trường :attribute phải ở giữa :min và :max chữ số.',
    'dimensions' => 'Trường :attribute có kích thước hình ảnh không hợp lệ.',
    'distinct' => 'Trường :attribute có giá trị trùng lặp.',
    'email' => 'Trường :attribute phải là một địa chỉ email hợp lệ.',
    'ends_with' => 'Trường :attribute phải kết thúc bằng một trong những điều sau: :values.',
    'exists' => 'Trường đã chọn :attribute không có hiệu lực.',
    'file' => 'Trường :attribute phải là một file.',
    'filled' => 'Trường :attribute phải có một giá trị.',
    'gt' => [
        'numeric' => 'Trường :attribute phải lớn hơn :value.',
        'file' => 'Trường :attribute phải lớn hơn :value kilobytes.',
        'string' => 'Trường :attribute phải lớn hơn :value kí tự.',
        'array' => 'Trường :attribute phải lớn hơn :value phần tử.',
    ],
    'gte' => [
        'numeric' => 'Trường :attribute phải lớn hơn hoặc bằng :value.',
        'file' => 'Trường :attribute phải lớn hơn hoặc bằng :value kilobytes.',
        'string' => 'Trường :attribute phải lớn hơn hoặc bằng :value phần tử.',
        'array' => 'Trường :attribute phải có :value các phần tử trở lên.',
    ],
    'image' => 'Trường :attribute phải là một hình ảnh.',
    'in' => 'Trường đã chọn :attribute không có hiệu lực.',
    'in_array' => 'Trường :attribute không tồn tại ở :other.',
    'integer' => 'Trường :attribute phải là số nguyên.',
    'ip' => 'Trường :attribute phải là một địa chỉ IP hợp lệ.',
    'ipv4' => 'Trường :attribute phải là địa chỉ IPv4 hợp lệ.',
    'ipv6' => 'Trường :attribute phải là địa chỉ IPv6 hợp lệ.',
    'json' => 'Trường :attribute phải là một chuỗi JSON hợp lệ.',
    'lt' => [
        'numeric' => 'Trường :attribute phải nhỏ hơn :value.',
        'file' => 'Trường :attribute phải nhỏ hơn :value kilobytes.',
        'string' => 'Trường :attribute phải nhỏ hơn :value kí tự.',
        'array' => 'Trường :attribute phải có ít hơn :value phần tử.',
    ],
    'lte' => [
        'numeric' => 'Trường :attribute phải nhỏ hơn hoặc bằng :value.',
        'file' => 'Trường :attribute phải nhỏ hơn hoặc bằng :value kilobytes.',
        'string' => 'Trường :attribute phải nhỏ hơn hoặc bằng :value kí tự.',
        'array' => 'Trường :attribute không được có nhiều hơn :value phần tử.',
    ],
    'max' => [
        'numeric' => 'Trường :attribute không được lớn hơn :max.',
        'file' => 'Trường :attribute không được lớn hơn :max kilobytes.',
        'string' => 'Trường :attribute không được lớn hơn :max kí tự.',
        'array' => 'Trường :attribute không được có nhiều hơn :max phần tử.',
    ],
    'mimes' => 'Trường :attribute phải là một loại tệp: :values.',
    'mimetypes' => 'Trường :attribute phải là một loại tệp: :values.',
    'min' => [
        'numeric' => 'Trường :attribute ít nhất phải là :min.',
        'file' => 'Trường :attribute ít nhất phải là :min kilobytes.',
        'string' => 'Trường :attribute ít nhất phải là :min kí tự.',
        'array' => 'Trường :attribute phải có ít nhất :min phần tử.',
    ],
    'multiple_of' => 'Trường :attribute phải là bội số của :value.',
    'not_in' => 'Trường đã chọn :attribute không hợp lệ.',
    'not_regex' => 'Trường :attribute định dạng không hợp lệ.',
    'numeric' => 'Trường :attribute phải là một số.',
    'password' => 'Trường password là không chính xác.',
    'present' => 'Trường :attribute phải có mặt.',
    'regex' => 'Trường :attribute định dạng không hợp lệ.',
    'required' => 'Trường :attribute không được để trống.',
    'required_if' => 'Trường :attribute được yêu cầu.',
    'required_unless' => 'Trường :attribute được yêu cầu trừ khi :other trong :values.',
    'required_with' => 'Trường :attribute được yêu cầu khi :values có mặt.',
    'required_with_all' => 'Trường :attribute được yêu cầu khi :values có mặt.',
    'required_without' => 'Trường :attribute được yêu cầu khi :values không có mặt.',
    'required_without_all' => 'Trường :attribute được yêu cầu khi không :values có mặt.',
    'prohibited' => 'Trường :attribute bị cấm.',
    'prohibited_if' => 'Trường :attribute bị cấm khi :other là :value.',
    'prohibited_unless' => 'Trường :attribute bị cấm trừ phi :other là :values.',
    'same' => 'Trường :attribute và :other phải phù hợp.',
    'size' => [
        'numeric' => 'Trường :attribute cần phải :size.',
        'file' => 'Trường :attribute cần phải :size kilobytes.',
        'string' => 'Trường :attribute cần phải :size kí tự.',
        'array' => 'Trường :attribute phải chứa :size phần tử.',
    ],
    'starts_with' => 'Trường :attribute phải bắt đầu bằng một trong những điều sau: :values.',
    'string' => 'Trường :attribute cần phải là một chuỗi.',
    'timezone' => 'Trường :attribute cần phải một khu vực hợp lệ.',
    'unique' => 'Trường :attribute đã tồn tại.',
    'uploaded' => 'Trường :attribute không tải lên được.',
    'url' => 'Trường :attribute định dạng không hợp lệ.',
    'uuid' => 'Trường :attribute cần phải có một UUID hợp lệ.',

    /*
    |--------------------------------------------------------------------------
    | Custom Validation Language Lines
    |--------------------------------------------------------------------------
    |
    | Here you may specify custom validation messages for attributes using the
    | convention "attribute.rule" to name the lines. This makes it quick to
    | specify a specific custom language line for a given attribute rule.
    |
    */

    'custom' => [
        'attribute-name' => [
            'rule-name' => 'custom-message',
        ],
    ],

    /*
    |--------------------------------------------------------------------------
    | Custom Validation Attributes
    |--------------------------------------------------------------------------
    |
    | The following language lines are used to swap our attribute placeholder
    | with something more reader friendly such as "E-Mail Address" instead
    | of "email". This simply helps us make our message more expressive.
    |
    */

    'attributes' => [],
    'not_exists' => "Trường :attribute không được xóa",
    'is_verifies' => "Tài khoản của bạn đang chờ quản trị viên phê duyệt",
    'actives' => "Tài khoản của bạn chưa được kích hoạt",

];
