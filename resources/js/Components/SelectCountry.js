import React from 'react'

const SelectCountry = ({data, value, onChange, type, error, name}) => {

    const changeValue = (item) => {
        if(name === 'city'){
            return item.matp;
        }else if(name === 'state'){
            return item.maqh;
        }else{
            return item.xaid;
        }
    }

    return (
        <div className="mb-5">
            <label className="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Select an {` ${name}`}</label>
            <select
                onChange={onChange}
                defaultValue={value}
                className="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500">
                <option value="">Choose a {` ${name}`}</option>
                {type[0] && <optgroup label={type[0]} className="font-semibold text-base">
                    {data.filter((item) => item.type === type[0]).map((item, index) => (<option key={index} value={changeValue(item)}>{item.name}</option>))}
                </optgroup>}
                {type[1] && <optgroup label={type[1]} className="font-semibold text-base">
                    {data.filter((item) => item.type === type[1]).map((item, index) => (<option key={index} value={changeValue(item)}>{item.name}</option>))}
                </optgroup>}
                {type[2] && <optgroup label={type[2]} className="font-semibold text-base">
                    {data.filter((item) => item.type === type[2]).map((item, index) => (<option key={index} value={changeValue(item)}>{item.name}</option>))}
                </optgroup>}
            </select>
            {error && <div className="text-red-600 text-xs mt-2">{error}</div>}
        </div>
    )
}

export default SelectCountry
