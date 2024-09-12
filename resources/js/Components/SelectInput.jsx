import {forwardRef, useEffect, useRef} from 'react';

export default forwardRef(function SelectInput({className = '', isFocused = false, options = [], ...props}, ref) {
    const input = ref ? ref : useRef();

    useEffect(() => {
        if (isFocused) {
            input.current.focus();
        }
    }, []);

    return (
        <select
            {...props}
            className={
                'border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm dark:border-gray-700 dark:bg-gray-900 dark:text-gray-300 dark:focus:border-indigo-600 dark:focus:ring-indigo-600 ' +
                className
            }
            ref={input}
        >
            <option key="" disabled hidden></option>
            {options.map((option) =>
                <option key={option}>{option}</option>
            )}
        </select>
    );
});
