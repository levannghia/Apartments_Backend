import React, { useRef, useEffect } from 'react'

const InputForm = ({
    type = 'text',
    name,
    value,
    className,
    autoComplete,
    required,
    isFocused,
    handleChange,
    placeholder,
    error
}) => {
    const input = useRef();

    useEffect(() => {
        if (isFocused) {
            input.current.focus();
        }
    }, []);
    return (
        <div className="mb-5">
            <label
                htmlFor={name}
                className="block mb-2 text-sm font-medium text-gray-900 dark:text-white"
            >
                {name}
            </label>
            <input
                ref={input}
                value={value}
                onChange={handleChange}
                type={type}
                id={name}
                className={`shadow-sm bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500 dark:shadow-sm-light ` + className}
                placeholder={placeholder}
                required={required}
                autoComplete={autoComplete}
            />
            {error && <div className="text-red-600 text-xs mt-2">{error}</div>}
        </div>
    )
}

export default InputForm
