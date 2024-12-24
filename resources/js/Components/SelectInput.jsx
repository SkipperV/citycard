import {forwardRef, useEffect, useRef} from 'react';
import {useTranslation} from "react-i18next";

export default forwardRef(function SelectInput({className = '', isFocused = false, options = [], object = '', value = '', ...props}, ref) {
    const {t} = useTranslation()

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
            value={value}
        >
            <option key="" disabled hidden></option>
            {options.map((option) =>
                <option key={option} value={option}>{t(`${object}.type.${option}`)}</option>
            )}
        </select>
    );
});
